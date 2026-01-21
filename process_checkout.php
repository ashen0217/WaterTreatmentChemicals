<?php
/**
 * Process Checkout Form Submission
 * Handles checkout form data and saves to database
 */
session_start();
require_once 'config.php';

// Initialize response
$response = [
    'success' => false,
    'message' => ''
];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: checkout.php');
    exit();
}

// Get database connection
$conn = getDatabaseConnection();

if (!$conn) {
    error_log('Checkout Error: Database connection failed');
    $_SESSION['checkout_error'] = 'Database connection failed. Please try again.';
    header('Location: checkout.php');
    exit();
}

// Log successful connection
error_log('Checkout: Database connection successful');

try {
    // Validate and sanitize inputs
    $full_name = sanitize_input($_POST['full_name'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $address_line1 = sanitize_input($_POST['address_line1'] ?? '');
    $address_line2 = sanitize_input($_POST['address_line2'] ?? '');
    $city = sanitize_input($_POST['city'] ?? '');
    $postal_code = sanitize_input($_POST['postal_code'] ?? '');
    $payment_method = sanitize_input($_POST['payment_method'] ?? 'cod');
    $cart_items = $_POST['cart_items'] ?? '';
    
    // Validate required fields
    if (empty($full_name) || empty($phone) || empty($address_line1) || empty($city) || empty($postal_code)) {
        error_log('Checkout Error: Missing required fields');
        $_SESSION['checkout_error'] = 'Please fill in all required fields.';
        header('Location: checkout.php');
        exit();
    }
    
    error_log('Checkout: All required fields validated');
    
    // Validate cart items
    if (empty($cart_items)) {
        error_log('Checkout Error: Cart items empty');
        $_SESSION['checkout_error'] = 'Your cart is empty. Please add items before checkout.';
        header('Location: checkout.php');
        exit();
    }
    
    error_log('Checkout: Cart items present - ' . substr($cart_items, 0, 100));
    
    // Validate JSON
    $cart_data = json_decode($cart_items, true);
    if (json_last_error() !== JSON_ERROR_NONE || empty($cart_data)) {
        error_log('Checkout Error: Invalid JSON - ' . json_last_error_msg());
        $_SESSION['checkout_error'] = 'Invalid cart data. Please try again.';
        header('Location: checkout.php');
        exit();
    }
    
    error_log('Checkout: Cart data validated - ' . count($cart_data) . ' items');
    
    // Validate payment method
    if (!in_array($payment_method, ['cod', 'card'])) {
        $payment_method = 'cod';
    }
    
    // Get user ID if logged in
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO checkout_details 
        (user_id, full_name, phone, address_line1, address_line2, city, postal_code, payment_method, cart_items, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    
    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param(
        "issssssss",
        $user_id,
        $full_name,
        $phone,
        $address_line1,
        $address_line2,
        $city,
        $postal_code,
        $payment_method,
        $cart_items
    );
    
    // Execute statement
    if ($stmt->execute()) {
        $checkout_id = $stmt->insert_id;
        
        error_log('Checkout Success: Inserted checkout ID ' . $checkout_id);
        
        // Set success message
        $_SESSION['checkout_success'] = 'Your quote request has been submitted successfully! Reference ID: #' . str_pad($checkout_id, 6, '0', STR_PAD_LEFT);
        
        // Close statement and connection
        $stmt->close();
        $conn->close();
        
        // Redirect to success page
        header('Location: checkout_success.php?id=' . $checkout_id);
        exit();
    } else {
        error_log('Checkout Error: Failed to execute statement - ' . $stmt->error);
        throw new Exception('Failed to insert checkout: ' . $stmt->error);
    }
    
} catch (Exception $e) {
    error_log('Checkout error: ' . $e->getMessage());
    $_SESSION['checkout_error'] = 'An error occurred while processing your request. Please try again.';
    
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
    
    header('Location: checkout.php');
    exit();
}
?>

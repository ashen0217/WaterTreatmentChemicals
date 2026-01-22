<?php
/**
 * Process Contact Form Submission
 * Handles contact form data and saves to database
 */

header('Content-Type: application/json');
require_once 'config.php';

// Start output buffering to prevent any whitespace
ob_start();

try {
    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    
    // Get form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $company = isset($_POST['company']) ? trim($_POST['company']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Validate required fields
    if (empty($name)) {
        throw new Exception('Name is required');
    }
    
    if (empty($email)) {
        throw new Exception('Email is required');
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }
    
    if (empty($subject)) {
        throw new Exception('Subject is required');
    }
    
    if (empty($message)) {
        throw new Exception('Message is required');
    }
    
    // Get database connection
    $conn = getDatabaseConnection();
    if (!$conn) {
        throw new Exception('Database connection failed');
    }
    
    // Prepare and execute insert statement
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, company, subject, message, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    
    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
    }
    
    $stmt->bind_param("ssssss", $name, $email, $phone, $company, $subject, $message);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to save contact message: ' . $stmt->error);
    }
    
    $contact_id = $stmt->insert_id;
    
    $stmt->close();
    $conn->close();
    
    // Clear output buffer
    ob_end_clean();
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for your message! We\'ll get back to you within 24 hours.',
        'contact_id' => $contact_id
    ]);
    
} catch (Exception $e) {
    // Clear output buffer
    ob_end_clean();
    
    // Return error response
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

<?php
/**
 * Process Signup - Save user registration to database
 */
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $full_name = sanitize_input($_POST['full-name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm-password'] ?? '';
    
    // Validation
    if (empty($full_name) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['signup_error'] = 'Please fill in all required fields';
        header("Location: signup.php");
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = 'Please enter a valid email address';
        header("Location: signup.php");
        exit();
    }
    
    if ($password !== $confirm_password) {
        $_SESSION['signup_error'] = 'Passwords do not match';
        header("Location: signup.php");
        exit();
    }
    
    if (strlen($password) < 6) {
        $_SESSION['signup_error'] = 'Password must be at least 6 characters long';
        header("Location: signup.php");
        exit();
    }
    
    $conn = getDatabaseConnection();
    if (!$conn) {
        $_SESSION['signup_error'] = 'Database connection failed';
        header("Location: signup.php");
        exit();
    }
    
    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $_SESSION['signup_error'] = 'Email already registered. Please login instead.';
        $check_stmt->close();
        $conn->close();
        header("Location: signup.php");
        exit();
    }
    $check_stmt->close();
    
    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password_hash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $phone, $password_hash);
    
    if ($stmt->execute()) {
        $_SESSION['signup_success'] = 'Account created successfully! Please login.';
        $stmt->close();
        $conn->close();
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['signup_error'] = 'Error creating account. Please try again.';
        $stmt->close();
        $conn->close();
        header("Location: signup.php");
        exit();
    }
} else {
    header("Location: signup.php");
    exit();
}
?>

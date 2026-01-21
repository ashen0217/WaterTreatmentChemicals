<?php
/**
 * Update Profile Script
 * Handles user profile updates including name, email, phone, company, and password
 */

require_once '../includes/auth_middleware.php';
require_once '../config.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = getDatabaseConnection();

if (!$conn) {
    $_SESSION['profile_error'] = 'Database connection failed';
    header("Location: dashboard.php");
    exit();
}

// Get form data
$full_name = sanitize_input($_POST['full_name'] ?? '');
$email = sanitize_input($_POST['email'] ?? '');
$phone = sanitize_input($_POST['phone'] ?? '');
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate required fields
if (empty($full_name) || empty($email)) {
    $_SESSION['profile_error'] = 'Full name and email are required';
    $conn->close();
    header("Location: dashboard.php");
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['profile_error'] = 'Invalid email format';
    $conn->close();
    header("Location: dashboard.php");
    exit();
}

// Check if email is already taken by another user
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$stmt->bind_param("si", $email, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['profile_error'] = 'Email is already in use by another account';
    $stmt->close();
    $conn->close();
    header("Location: dashboard.php");
    exit();
}
$stmt->close();

// Handle password update if provided
$update_password = false;
$password_hash = '';

if (!empty($new_password)) {
    // Validate password match
    if ($new_password !== $confirm_password) {
        $_SESSION['profile_error'] = 'Passwords do not match';
        $conn->close();
        header("Location: dashboard.php");
        exit();
    }
    
    // Validate password length
    if (strlen($new_password) < 6) {
        $_SESSION['profile_error'] = 'Password must be at least 6 characters long';
        $conn->close();
        header("Location: dashboard.php");
        exit();
    }
    
    $update_password = true;
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
}

// Update user profile
if ($update_password) {
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, password_hash = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $full_name, $email, $phone, $password_hash, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("sssi", $full_name, $email, $phone, $user_id);
}

if ($stmt->execute()) {
    // Update session variables
    $_SESSION['user_name'] = $full_name;
    $_SESSION['user_email'] = $email;
    
    $_SESSION['profile_success'] = 'Profile updated successfully!';
} else {
    $_SESSION['profile_error'] = 'Failed to update profile. Please try again.';
}

$stmt->close();
$conn->close();

header("Location: dashboard.php");
exit();
?>

<?php
/**
 * Process Reset Password - Update user password
 */
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = sanitize_input($_POST['token'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate inputs
    if (empty($token)) {
        $_SESSION['reset_error'] = 'Invalid reset token';
        header("Location: forgot_password.php");
        exit();
    }
    
    if (empty($password) || empty($confirm_password)) {
        $_SESSION['reset_error'] = 'Please enter both password fields';
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }
    
    if ($password !== $confirm_password) {
        $_SESSION['reset_error'] = 'Passwords do not match';
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }
    
    if (strlen($password) < 6) {
        $_SESSION['reset_error'] = 'Password must be at least 6 characters long';
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }
    
    $conn = getDatabaseConnection();
    if (!$conn) {
        $_SESSION['reset_error'] = 'Database connection failed';
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }
    
    // Verify token and check expiration
    $stmt = $conn->prepare("SELECT id, email, reset_token_expires FROM users WHERE reset_token = ? AND is_active = 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['reset_error'] = 'Invalid reset token';
        $stmt->close();
        $conn->close();
        header("Location: forgot_password.php");
        exit();
    }
    
    $user = $result->fetch_assoc();
    $stmt->close();
    
    // Check if token has expired
    $expires = strtotime($user['reset_token_expires']);
    $now = time();
    
    if ($now > $expires) {
        $_SESSION['reset_error'] = 'This reset link has expired. Please request a new one.';
        $conn->close();
        header("Location: forgot_password.php");
        exit();
    }
    
    // Hash the new password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Update password and clear reset token
    $update_stmt = $conn->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, reset_token_expires = NULL WHERE id = ?");
    $update_stmt->bind_param("si", $password_hash, $user['id']);
    
    if ($update_stmt->execute()) {
        $_SESSION['login_success'] = 'Password reset successful! Please log in with your new password.';
        $update_stmt->close();
        $conn->close();
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['reset_error'] = 'Failed to update password. Please try again.';
        $update_stmt->close();
        $conn->close();
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }
} else {
    header("Location: forgot_password.php");
    exit();
}
?>

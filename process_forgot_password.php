<?php
/**
 * Process Forgot Password - Verify email and generate reset token
 */
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email'] ?? '');
    
    if (empty($email)) {
        $_SESSION['forgot_error'] = 'Please enter your email address';
        header("Location: forgot_password.php");
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['forgot_error'] = 'Please enter a valid email address';
        header("Location: forgot_password.php");
        exit();
    }
    
    $conn = getDatabaseConnection();
    if (!$conn) {
        $_SESSION['forgot_error'] = 'Database connection failed';
        header("Location: forgot_password.php");
        exit();
    }
    
    // Check if email exists in users table
    $stmt = $conn->prepare("SELECT id, email, full_name FROM users WHERE email = ? AND is_active = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Generate secure random token
        $token = bin2hex(random_bytes(32)); // 64 character token
        
        // Set token expiration (15 minutes from now)
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        
        // Update user with reset token
        $update_stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expires = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $token, $expires, $user['id']);
        
        if ($update_stmt->execute()) {
            // Store token in session for display (development mode)
            $_SESSION['reset_token'] = $token;
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_name'] = $user['full_name'];
            
            $update_stmt->close();
            $stmt->close();
            $conn->close();
            
            // Redirect to success page
            header("Location: forgot_password_success.php");
            exit();
        } else {
            $_SESSION['forgot_error'] = 'Failed to generate reset token. Please try again.';
            $update_stmt->close();
            $stmt->close();
            $conn->close();
            header("Location: forgot_password.php");
            exit();
        }
    } else {
        // Email not found - for security, we'll show a generic success message
        // but in development, we'll show the actual error
        $_SESSION['forgot_error'] = 'No account found with that email address';
        $stmt->close();
        $conn->close();
        header("Location: forgot_password.php");
        exit();
    }
} else {
    header("Location: forgot_password.php");
    exit();
}
?>

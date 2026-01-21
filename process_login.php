<?php
/**
 * Process Login - Handles both user and admin authentication
 */
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = 'Please enter both email and password';
        header("Location: login.php");
        exit();
    }
    
    $conn = getDatabaseConnection();
    if (!$conn) {
        $_SESSION['login_error'] = 'Database connection failed';
        header("Location: login.php");
        exit();
    }
    
    // First, check if user is an admin
    $stmt = $conn->prepare("SELECT id, email, password_hash, full_name FROM admin_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Admin login
        $admin = $result->fetch_assoc();
        
        if (password_verify($password, $admin['password_hash'])) {
            // Update last login
            $update_stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
            $update_stmt->bind_param("i", $admin['id']);
            $update_stmt->execute();
            $update_stmt->close();
            
            // Set admin session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['is_admin'] = true;
            
            $stmt->close();
            $conn->close();
            
            // Redirect to admin dashboard
            header("Location: admin/index.php");
            exit();
        } else {
            $_SESSION['login_error'] = 'Invalid email or password';
            $stmt->close();
            $conn->close();
            header("Location: login.php");
            exit();
        }
    }
    
    $stmt->close();
    
    // If not admin, check regular users table
    $stmt = $conn->prepare("SELECT id, email, password_hash, full_name FROM users WHERE email = ? AND is_active = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Regular user login
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password_hash'])) {
            // Set user session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['is_admin'] = false;
            
            $stmt->close();
            $conn->close();
            
            // Redirect to user dashboard
            header("Location: user/dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = 'Invalid email or password';
            $stmt->close();
            $conn->close();
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = 'Invalid email or password';
        $stmt->close();
        $conn->close();
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>

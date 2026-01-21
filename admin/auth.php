<?php
/**
 * Admin Authentication Handler
 * Provides authentication functions for admin panel
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database configuration
require_once __DIR__ . '/../config.php';

/**
 * Check if user is logged in as admin
 */
function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

/**
 * Require admin authentication - redirect to login if not authenticated
 */
function require_admin() {
    if (!is_admin()) {
        $_SESSION['login_error'] = 'Admin access required. Please login with admin credentials.';
        header("Location: ../login.php");
        exit();
    }
}

/**
 * Get current admin user data
 */
function get_admin_user() {
    if (!is_admin()) {
        return null;
    }
    
    $conn = getDatabaseConnection();
    if (!$conn) {
        return null;
    }
    
    $admin_id = $_SESSION['admin_id'];
    $stmt = $conn->prepare("SELECT id, email, full_name, created_at, last_login FROM admin_users WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    
    $stmt->close();
    $conn->close();
    
    return $admin;
}

/**
 * Authenticate admin user
 */
function authenticate_admin($email, $password) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    $stmt = $conn->prepare("SELECT id, email, password_hash, full_name FROM admin_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Invalid email or password'];
    }
    
    $admin = $result->fetch_assoc();
    
    if (password_verify($password, $admin['password_hash'])) {
        // Update last login
        $update_stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
        $update_stmt->bind_param("i", $admin['id']);
        $update_stmt->execute();
        $update_stmt->close();
        
        // Set session variables
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_name'] = $admin['full_name'];
        
        $stmt->close();
        $conn->close();
        
        return ['success' => true, 'message' => 'Login successful'];
    } else {
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Invalid email or password'];
    }
}

/**
 * Logout admin user
 */
function logout_admin() {
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_email']);
    unset($_SESSION['admin_name']);
    session_destroy();
}
?>

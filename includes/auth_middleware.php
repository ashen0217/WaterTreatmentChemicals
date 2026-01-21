<?php
/**
 * Authentication Middleware
 * Include this file at the top of pages that require user authentication
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * Redirects to login page if not authenticated
 */
function require_login($redirect_after_login = true) {
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        // Store the current page URL for redirect after login
        if ($redirect_after_login) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        }
        
        // Set error message
        $_SESSION['login_error'] = 'Please log in to access this page.';
        
        // Redirect to login page
        header("Location: " . get_base_url() . "login.php");
        exit();
    }
}

/**
 * Get the base URL of the application
 */
function get_base_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $path = dirname($script);
    
    // Remove /user from path if present
    $path = str_replace('/user', '', $path);
    
    // Ensure path ends with /
    if (substr($path, -1) !== '/') {
        $path .= '/';
    }
    
    return $protocol . "://" . $host . $path;
}

/**
 * Get current logged in user data
 */
function get_logged_in_user() {
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    
    require_once __DIR__ . '/../config.php';
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        return null;
    }
    
    $stmt = $conn->prepare("SELECT id, email, full_name, phone, created_at FROM users WHERE id = ? AND is_active = 1");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $user;
    }
    
    $stmt->close();
    $conn->close();
    return null;
}

/**
 * Check if user is logged in (without redirect)
 */
function is_user_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}
?>

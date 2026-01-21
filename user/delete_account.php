<?php
/**
 * Delete Account Handler
 * Permanently deletes the user's account and all associated data
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/auth_middleware.php';
require_login();

$user = get_logged_in_user();
if (!$user) {
    $_SESSION['profile_error'] = 'User not found or not logged in.';
    header("Location: ../login.php");
    exit();
}

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['profile_error'] = 'Invalid request method. Please use the delete button.';
    header("Location: dashboard.php");
    exit();
}

// Verify the user wants to delete their account
if (!isset($_POST['confirm_delete']) || $_POST['confirm_delete'] !== 'yes') {
    $_SESSION['profile_error'] = 'Account deletion was not confirmed.';
    header("Location: dashboard.php");
    exit();
}

require_once '../config.php';
$conn = getDatabaseConnection();

if (!$conn) {
    $_SESSION['profile_error'] = 'Database connection failed. Please try again later.';
    header("Location: dashboard.php");
    exit();
}

$user_id = $user['id'];
$success = true;
$error_message = '';

// Start transaction
$conn->begin_transaction();

try {
    // Delete user's checkout details (set user_id to NULL due to foreign key constraint)
    $stmt = $conn->prepare("UPDATE checkout_details SET user_id = NULL WHERE user_id = ?");
    if (!$stmt) {
        throw new Exception("Failed to prepare checkout update statement: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to update checkout details: " . $stmt->error);
    }
    $stmt->close();
    
    // Delete the user account
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Failed to prepare delete statement: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to delete user account: " . $stmt->error);
    }
    
    $affected_rows = $stmt->affected_rows;
    $stmt->close();
    
    if ($affected_rows === 0) {
        throw new Exception("No user was deleted. User ID: " . $user_id . " may not exist.");
    }
    
    // Commit transaction
    $conn->commit();
    $conn->close();
    
    // Clear session and redirect to homepage with success message
    session_destroy();
    
    // Redirect to homepage with success message in URL parameter
    header("Location: ../index.php?account_deleted=1");
    exit();
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    $error_message = $e->getMessage();
    error_log("Account deletion error: " . $error_message);
    
    $_SESSION['profile_error'] = 'Failed to delete account: ' . $error_message;
    $conn->close();
    header("Location: dashboard.php");
    exit();
}
?>

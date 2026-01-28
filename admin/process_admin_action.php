<?php
/**
 * Process Admin Actions
 * Handles create, update, and delete operations for admin users
 */

define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';
require_admin();

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admins.php");
    exit();
}

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
    case 'create':
        handle_create_admin();
        break;
    
    case 'update':
        handle_update_admin();
        break;
    
    case 'delete':
        handle_delete_admin();
        break;
    
    default:
        $_SESSION['error_message'] = 'Invalid action';
        header("Location: admins.php");
        exit();
}

/**
 * Handle create admin
 */
function handle_create_admin() {
    // Validate input
    $required_fields = ['full_name', 'email', 'password', 'confirm_password'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['error_message'] = 'All fields are required';
            header("Location: admin_form.php");
            exit();
        }
    }
    
    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Invalid email address';
        header("Location: admin_form.php");
        exit();
    }
    
    // Validate password
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $_SESSION['error_message'] = 'Passwords do not match';
        header("Location: admin_form.php");
        exit();
    }
    
    if (strlen($_POST['password']) < 6) {
        $_SESSION['error_message'] = 'Password must be at least 6 characters';
        header("Location: admin_form.php");
        exit();
    }
    
    // Prepare data
    $data = [
        'full_name' => trim($_POST['full_name']),
        'email' => trim($_POST['email']),
        'password' => $_POST['password']
    ];
    
    // Create admin
    $result = create_admin($data);
    
    if ($result['success']) {
        $_SESSION['success_message'] = 'Admin created successfully';
        header("Location: admins.php");
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: admin_form.php");
    }
    exit();
}

/**
 * Handle update admin
 */
function handle_update_admin() {
    // Validate input
    if (empty($_POST['id']) || empty($_POST['full_name']) || empty($_POST['email'])) {
        $_SESSION['error_message'] = 'Full name and email are required';
        header("Location: admin_form.php?id=" . intval($_POST['id']));
        exit();
    }
    
    $admin_id = intval($_POST['id']);
    
    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Invalid email address';
        header("Location: admin_form.php?id=" . $admin_id);
        exit();
    }
    
    // Validate password if provided
    if (!empty($_POST['password']) || !empty($_POST['confirm_password'])) {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $_SESSION['error_message'] = 'Passwords do not match';
            header("Location: admin_form.php?id=" . $admin_id);
            exit();
        }
        
        if (strlen($_POST['password']) < 6) {
            $_SESSION['error_message'] = 'Password must be at least 6 characters';
            header("Location: admin_form.php?id=" . $admin_id);
            exit();
        }
    }
    
    // Prepare data
    $data = [
        'full_name' => trim($_POST['full_name']),
        'email' => trim($_POST['email']),
        'password' => !empty($_POST['password']) ? $_POST['password'] : ''
    ];
    
    // Update admin
    $result = update_admin($admin_id, $data);
    
    if ($result['success']) {
        $_SESSION['success_message'] = 'Admin updated successfully';
        header("Location: admins.php");
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: admin_form.php?id=" . $admin_id);
    }
    exit();
}

/**
 * Handle delete admin
 */
function handle_delete_admin() {
    if (empty($_POST['id'])) {
        $_SESSION['error_message'] = 'Admin ID is required';
        header("Location: admins.php");
        exit();
    }
    
    $admin_id = intval($_POST['id']);
    $current_admin = get_admin_user();
    
    // Prevent self-deletion through this method
    if ($admin_id == $current_admin['id']) {
        $_SESSION['error_message'] = 'Cannot delete your own account. Use the self-delete option if you want to remove your account.';
        header("Location: admins.php");
        exit();
    }
    
    // Delete admin
    $result = delete_admin($admin_id);
    
    if ($result['success']) {
        $_SESSION['success_message'] = 'Admin deleted successfully';
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header("Location: admins.php");
    exit();
}
?>

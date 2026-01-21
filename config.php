<?php
/**
 * Database Configuration File
 * Configure your database connection settings here
 */

// Database configuration constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'water_treatment');

// Create database connection
function getDatabaseConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Set charset to utf8mb4 for full Unicode support
        $conn->set_charset("utf8mb4");
        
        return $conn;
    } catch (Exception $e) {
        error_log("Database connection error: " . $e->getMessage());
        return null;
    }
}

// Site configuration
define('SITE_NAME', 'Water Treatment Chemicals');
define('SITE_URL', 'http://localhost/WaterTreatmentChemicals/');
define('SITE_EMAIL', 'info@waterTreatmentChemicals.com');
define('SITE_PHONE', '+1 (555) 123-4567');

// Timezone
date_default_timezone_set('Asia/Colombo');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Helper function to sanitize user input
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Helper function to redirect
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Helper function to check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

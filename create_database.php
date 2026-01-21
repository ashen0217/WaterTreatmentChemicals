<?php
/**
 * Database Creation Script
 * Run this file FIRST to create the Water Treatment Chemicals database
 * Access: http://localhost/WaterTreatmentChemicals/create_database.php
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'water_treatment');

// Create connection without database selection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";

$success = false;
$message = '';

if ($conn->query($sql) === TRUE) {
    $success = true;
    $message = "Database '" . DB_NAME . "' created successfully or already exists.";
} else {
    $message = "Error creating database: " . $conn->error;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Database - Water Treatment Chemicals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="gradient-bg text-white p-8">
                <h1 class="text-3xl font-bold mb-2">Database Creation</h1>
                <p class="text-blue-100">Water Treatment Chemicals Admin Dashboard Setup - Step 1</p>
            </div>
            
            <!-- Content -->
            <div class="p-8">
                <?php if ($success): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                        <h2 class="text-green-800 font-semibold text-lg mb-3 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Success
                        </h2>
                        <p class="text-green-700 font-mono text-sm"><?php echo htmlspecialchars($message); ?></p>
                    </div>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                        <h3 class="text-blue-800 font-semibold mb-2">Next Step:</h3>
                        <p class="text-blue-700 mb-4">Now that the database is created, proceed to initialize the tables and create the admin account.</p>
                    </div>
                    
                    <div class="flex gap-4">
                        <a href="admin/init_database.php" class="flex-1 gradient-bg text-white text-center px-6 py-4 rounded-lg font-semibold hover:opacity-90 transition-all shadow-lg">
                            Initialize Database Tables
                        </a>
                        <a href="index.php" class="flex-1 bg-gray-200 text-gray-800 text-center px-6 py-4 rounded-lg font-semibold hover:bg-gray-300 transition-all">
                            Back to Website
                        </a>
                    </div>
                <?php else: ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                        <h2 class="text-red-800 font-semibold text-lg mb-3 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Error
                        </h2>
                        <p class="text-red-700 font-mono text-sm"><?php echo htmlspecialchars($message); ?></p>
                    </div>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg mb-6">
                        <h3 class="text-yellow-800 font-semibold mb-2">Troubleshooting:</h3>
                        <ul class="list-disc list-inside space-y-2 text-yellow-700 text-sm">
                            <li>Make sure XAMPP MySQL service is running</li>
                            <li>Check if the database credentials in config.php are correct</li>
                            <li>Verify that the MySQL user has permission to create databases</li>
                        </ul>
                    </div>
                    
                    <div class="text-center">
                        <button onclick="location.reload()" class="gradient-bg text-white px-8 py-4 rounded-lg font-semibold hover:opacity-90 transition-all shadow-lg">
                            Try Again
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p>⚠️ <strong>Important:</strong> This file should be deleted after database creation for security reasons.</p>
        </div>
    </div>
</body>
</html>

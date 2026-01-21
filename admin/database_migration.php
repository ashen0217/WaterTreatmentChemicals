<?php
/**
 * Database Migration Script - Add Password Reset Functionality
 * Adds reset_token and reset_token_expires columns to users table
 * Access: http://localhost/WaterTreatmentChemicals/admin/database_migration.php
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'water_treatment');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = true;
$messages = [];
$errors = [];

// Set charset
$conn->set_charset("utf8mb4");

// Check if columns already exist
$check_columns = $conn->query("SHOW COLUMNS FROM users LIKE 'reset_token'");
if ($check_columns->num_rows > 0) {
    $messages[] = "Password reset columns already exist in users table";
} else {
    // Add reset_token column
    $sql_add_token = "ALTER TABLE users 
                      ADD COLUMN reset_token VARCHAR(64) NULL AFTER password_hash,
                      ADD COLUMN reset_token_expires DATETIME NULL AFTER reset_token";
    
    if ($conn->query($sql_add_token) === TRUE) {
        $messages[] = "Added reset_token and reset_token_expires columns to users table";
        
        // Add index on reset_token
        $sql_add_index = "ALTER TABLE users ADD INDEX idx_reset_token (reset_token)";
        
        if ($conn->query($sql_add_index) === TRUE) {
            $messages[] = "Added index on reset_token column for performance";
        } else {
            $errors[] = "Error adding index: " . $conn->error;
            $success = false;
        }
    } else {
        $errors[] = "Error adding columns: " . $conn->error;
        $success = false;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Migration - Password Reset</title>
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
    <div class="max-w-3xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="gradient-bg text-white p-8">
                <h1 class="text-3xl font-bold mb-2">Database Migration</h1>
                <p class="text-blue-100">Password Reset Functionality</p>
            </div>
            
            <!-- Content -->
            <div class="p-8">
                <?php if ($success && empty($errors)): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                        <h2 class="text-green-800 font-semibold text-lg mb-3 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Success! Migration Completed
                        </h2>
                        <div class="space-y-2">
                            <?php foreach ($messages as $message): ?>
                                <p class="text-green-700 text-sm">✓ <?php echo htmlspecialchars($message); ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                        <h3 class="text-blue-800 font-semibold mb-3">What's Next?</h3>
                        <p class="text-blue-700 text-sm">The users table now has password reset functionality. Users can now use the "Forgot Password" feature on the login page.</p>
                    </div>
                    
                    <div class="flex gap-4">
                        <a href="../login.php" class="flex-1 gradient-bg text-white text-center px-6 py-4 rounded-lg font-semibold hover:opacity-90 transition-all shadow-lg">
                            Go to Login Page
                        </a>
                        <a href="../index.php" class="flex-1 bg-gray-200 text-gray-800 text-center px-6 py-4 rounded-lg font-semibold hover:bg-gray-300 transition-all">
                            Back to Website
                        </a>
                    </div>
                <?php else: ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                        <h2 class="text-red-800 font-semibold text-lg mb-3 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Errors Occurred
                        </h2>
                        <div class="space-y-2">
                            <?php foreach ($errors as $error): ?>
                                <p class="text-red-700 text-sm">✗ <?php echo htmlspecialchars($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <?php if (!empty($messages)): ?>
                        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg">
                            <h3 class="text-yellow-800 font-semibold mb-2">Partial Success:</h3>
                            <div class="space-y-2">
                                <?php foreach ($messages as $message): ?>
                                    <p class="text-yellow-700 text-sm">✓ <?php echo htmlspecialchars($message); ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="text-center">
                        <button onclick="location.reload()" class="gradient-bg text-white px-8 py-4 rounded-lg font-semibold hover:opacity-90 transition-all shadow-lg">
                            Try Again
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p>⚠️ <strong>Security Note:</strong> Delete this file after successful migration.</p>
        </div>
    </div>
</body>
</html>

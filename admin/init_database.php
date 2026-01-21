<?php
/**
 * Database Initialization Script for Admin Dashboard
 * Creates all required tables and inserts initial data
 * Access: http://localhost/WaterTreatmentChemicals/admin/init_database.php
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

// 1. Create admin_users table
$sql_admin_users = "CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql_admin_users) === TRUE) {
    $messages[] = "Table 'admin_users' created successfully";
} else {
    $errors[] = "Error creating admin_users table: " . $conn->error;
    $success = false;
}

// 2. Create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1,
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql_users) === TRUE) {
    $messages[] = "Table 'users' created successfully";
} else {
    $errors[] = "Error creating users table: " . $conn->error;
    $success = false;
}

// 3. Create products table
$sql_products = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    formula VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    form VARCHAR(100) NOT NULL,
    purity VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    price_index INT NOT NULL,
    effectiveness INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1,
    INDEX idx_category (category),
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql_products) === TRUE) {
    $messages[] = "Table 'products' created successfully";
} else {
    $errors[] = "Error creating products table: " . $conn->error;
    $success = false;
}

// 4. Insert default admin account
$admin_email = "admin@hydrochem.com";
$admin_password = "admin123";
$admin_name = "System Administrator";
$admin_password_hash = password_hash($admin_password, PASSWORD_DEFAULT);

// Check if admin already exists
$check_admin = $conn->query("SELECT id FROM admin_users WHERE email = '$admin_email'");
if ($check_admin->num_rows == 0) {
    $sql_insert_admin = "INSERT INTO admin_users (email, password_hash, full_name) 
                         VALUES ('$admin_email', '$admin_password_hash', '$admin_name')";
    
    if ($conn->query($sql_insert_admin) === TRUE) {
        $messages[] = "Default admin account created (Email: $admin_email, Password: $admin_password)";
    } else {
        $errors[] = "Error creating admin account: " . $conn->error;
        $success = false;
    }
} else {
    $messages[] = "Admin account already exists";
}

// 5. Migrate products from data.php
include '../includes/data.php';

// Check if products already exist
$check_products = $conn->query("SELECT COUNT(*) as count FROM products");
$product_count = $check_products->fetch_assoc()['count'];

if ($product_count == 0 && isset($products)) {
    $stmt = $conn->prepare("INSERT INTO products (id, name, formula, category, form, purity, description, price_index, effectiveness) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $inserted_count = 0;
    foreach ($products as $product) {
        $stmt->bind_param("issssssii", 
            $product['id'],
            $product['name'],
            $product['formula'],
            $product['category'],
            $product['form'],
            $product['purity'],
            $product['desc'],
            $product['price_index'],
            $product['effectiveness']
        );
        
        if ($stmt->execute()) {
            $inserted_count++;
        } else {
            $errors[] = "Error inserting product '{$product['name']}': " . $stmt->error;
        }
    }
    
    $stmt->close();
    $messages[] = "Migrated $inserted_count products from data.php to database";
} else {
    $messages[] = "Products already exist in database ($product_count products found)";
}

// 6. Create checkout_details table
$sql_checkout_details = "CREATE TABLE IF NOT EXISTS checkout_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address_line1 VARCHAR(255) NOT NULL,
    address_line2 VARCHAR(255) NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    payment_method ENUM('cod', 'card') NOT NULL DEFAULT 'cod',
    cart_items JSON NOT NULL,
    status ENUM('pending', 'approved', 'ignored') NOT NULL DEFAULT 'pending',
    admin_notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql_checkout_details) === TRUE) {
    $messages[] = "Table 'checkout_details' created successfully";
} else {
    $errors[] = "Error creating checkout_details table: " . $conn->error;
    $success = false;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initialize Database - Admin Dashboard</title>
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
                <h1 class="text-3xl font-bold mb-2">Database Initialization</h1>
                <p class="text-blue-100">Admin Dashboard Setup - Step 2</p>
            </div>
            
            <!-- Content -->
            <div class="p-8">
                <?php if ($success && empty($errors)): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                        <h2 class="text-green-800 font-semibold text-lg mb-3 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Success! Database Initialized
                        </h2>
                        <div class="space-y-2">
                            <?php foreach ($messages as $message): ?>
                                <p class="text-green-700 text-sm">✓ <?php echo htmlspecialchars($message); ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                        <h3 class="text-blue-800 font-semibold mb-3">Admin Credentials:</h3>
                        <div class="bg-white p-4 rounded-lg font-mono text-sm space-y-2">
                            <p><strong>Email:</strong> admin@hydrochem.com</p>
                            <p><strong>Password:</strong> admin123</p>
                        </div>
                        <p class="text-blue-700 text-sm mt-3">⚠️ Please change the default password after first login!</p>
                    </div>
                    
                    <div class="flex gap-4">
                        <a href="login.php" class="flex-1 gradient-bg text-white text-center px-6 py-4 rounded-lg font-semibold hover:opacity-90 transition-all shadow-lg">
                            Go to Admin Login
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
            <p>⚠️ <strong>Security Note:</strong> Delete this file after successful initialization.</p>
        </div>
    </div>
</body>
</html>

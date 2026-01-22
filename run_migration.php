<?php
/**
 * Database Migration Script
 * Adds image_path column to products table
 */

require_once 'config.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Migration - Add Image Path</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: green; background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; background: #d1ecf1; padding: 15px; border-radius: 5px; margin: 10px 0; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Database Migration: Add Image Path Column</h1>
";

$conn = getDatabaseConnection();

if (!$conn) {
    echo "<div class='error'>❌ Failed to connect to database. Please check your database configuration in config.php</div>";
    echo "</body></html>";
    exit;
}

echo "<div class='info'>✓ Connected to database: " . DB_NAME . "</div>";

// Check if column already exists
$check_query = "SHOW COLUMNS FROM products LIKE 'image_path'";
$result = $conn->query($check_query);

if ($result->num_rows > 0) {
    echo "<div class='info'>ℹ️ Column 'image_path' already exists in products table. No migration needed.</div>";
} else {
    echo "<div class='info'>📝 Adding 'image_path' column to products table...</div>";
    
    // Run migration
    $migration_sql = "ALTER TABLE products ADD COLUMN image_path VARCHAR(255) DEFAULT NULL AFTER description";
    
    if ($conn->query($migration_sql) === TRUE) {
        echo "<div class='success'>✅ Migration completed successfully!</div>";
        echo "<div class='success'>Column 'image_path' has been added to the products table.</div>";
        
        // Verify the column was added
        $verify_query = "SHOW COLUMNS FROM products LIKE 'image_path'";
        $verify_result = $conn->query($verify_query);
        
        if ($verify_result->num_rows > 0) {
            $column_info = $verify_result->fetch_assoc();
            echo "<div class='info'><strong>Column Details:</strong><pre>";
            print_r($column_info);
            echo "</pre></div>";
        }
    } else {
        echo "<div class='error'>❌ Migration failed: " . $conn->error . "</div>";
    }
}

// Show current products table structure
echo "<h2>Current Products Table Structure:</h2>";
$structure_query = "DESCRIBE products";
$structure_result = $conn->query($structure_query);

if ($structure_result) {
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    while ($row = $structure_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . htmlspecialchars($row['Field']) . "</strong></td>";
        echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($row['Extra']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
}

$conn->close();

echo "
    <div style='margin-top: 30px; padding: 15px; background: #e7f3ff; border-radius: 5px;'>
        <h3>Next Steps:</h3>
        <ol>
            <li>The migration is complete! You can now upload product images.</li>
            <li>Go to the admin panel → Products → Edit/Add Product</li>
            <li>Upload images in JPG, PNG, GIF, or WebP format (max 5MB)</li>
            <li>For security, you can delete this migration file after running it.</li>
        </ol>
    </div>
</body>
</html>";
?>

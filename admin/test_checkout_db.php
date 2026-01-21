&lt;?php
/**
 * Test Database Connection and Checkout Table
 * This script checks if the checkout_details table exists and tests insertion
 */

require_once '../config.php';

$conn = getDatabaseConnection();

if (!$conn) {
    die("Database connection failed!");
}

echo "&lt;h2&gt;Database Connection Test&lt;/h2&gt;";
echo "&lt;p style='color: green;'&gt;✓ Database connected successfully!&lt;/p&gt;";

// Check if checkout_details table exists
$result = $conn-&gt;query("SHOW TABLES LIKE 'checkout_details'");

if ($result-&gt;num_rows &gt; 0) {
    echo "&lt;p style='color: green;'&gt;✓ Table 'checkout_details' exists&lt;/p&gt;";
    
    // Show table structure
    echo "&lt;h3&gt;Table Structure:&lt;/h3&gt;";
    $structure = $conn-&gt;query("DESCRIBE checkout_details");
    echo "&lt;table border='1' cellpadding='5'&gt;";
    echo "&lt;tr&gt;&lt;th&gt;Field&lt;/th&gt;&lt;th&gt;Type&lt;/th&gt;&lt;th&gt;Null&lt;/th&gt;&lt;th&gt;Key&lt;/th&gt;&lt;th&gt;Default&lt;/th&gt;&lt;/tr&gt;";
    while ($row = $structure-&gt;fetch_assoc()) {
        echo "&lt;tr&gt;";
        echo "&lt;td&gt;" . $row['Field'] . "&lt;/td&gt;";
        echo "&lt;td&gt;" . $row['Type'] . "&lt;/td&gt;";
        echo "&lt;td&gt;" . $row['Null'] . "&lt;/td&gt;";
        echo "&lt;td&gt;" . $row['Key'] . "&lt;/td&gt;";
        echo "&lt;td&gt;" . $row['Default'] . "&lt;/td&gt;";
        echo "&lt;/tr&gt;";
    }
    echo "&lt;/table&gt;";
    
    // Count existing records
    $count_result = $conn-&gt;query("SELECT COUNT(*) as count FROM checkout_details");
    $count = $count_result-&gt;fetch_assoc()['count'];
    echo "&lt;p&gt;Total records in checkout_details: &lt;strong&gt;$count&lt;/strong&gt;&lt;/p&gt;";
    
    // Show recent records
    if ($count &gt; 0) {
        echo "&lt;h3&gt;Recent Checkout Records:&lt;/h3&gt;";
        $records = $conn-&gt;query("SELECT * FROM checkout_details ORDER BY created_at DESC LIMIT 5");
        echo "&lt;table border='1' cellpadding='5'&gt;";
        echo "&lt;tr&gt;&lt;th&gt;ID&lt;/th&gt;&lt;th&gt;Name&lt;/th&gt;&lt;th&gt;Phone&lt;/th&gt;&lt;th&gt;City&lt;/th&gt;&lt;th&gt;Status&lt;/th&gt;&lt;th&gt;Created&lt;/th&gt;&lt;/tr&gt;";
        while ($row = $records-&gt;fetch_assoc()) {
            echo "&lt;tr&gt;";
            echo "&lt;td&gt;" . $row['id'] . "&lt;/td&gt;";
            echo "&lt;td&gt;" . htmlspecialchars($row['full_name']) . "&lt;/td&gt;";
            echo "&lt;td&gt;" . htmlspecialchars($row['phone']) . "&lt;/td&gt;";
            echo "&lt;td&gt;" . htmlspecialchars($row['city']) . "&lt;/td&gt;";
            echo "&lt;td&gt;" . $row['status'] . "&lt;/td&gt;";
            echo "&lt;td&gt;" . $row['created_at'] . "&lt;/td&gt;";
            echo "&lt;/tr&gt;";
        }
        echo "&lt;/table&gt;";
    }
    
} else {
    echo "&lt;p style='color: red;'&gt;✗ Table 'checkout_details' does NOT exist!&lt;/p&gt;";
    echo "&lt;p&gt;Please run &lt;a href='init_database.php'&gt;init_database.php&lt;/a&gt; to create the table.&lt;/p&gt;";
}

// Test insert (commented out for safety)
echo "&lt;h3&gt;Test Insert:&lt;/h3&gt;";
echo "&lt;p&gt;To test insertion, uncomment the test code in this file.&lt;/p&gt;";

/*
// Uncomment to test insertion
$test_data = [
    'user_id' =&gt; null,
    'full_name' =&gt; 'Test User',
    'phone' =&gt; '+94 771234567',
    'address_line1' =&gt; '123 Test Street',
    'address_line2' =&gt; '',
    'city' =&gt; 'Colombo',
    'postal_code' =&gt; '10100',
    'payment_method' =&gt; 'cod',
    'cart_items' =&gt; json_encode([['id' =&gt; 1, 'name' =&gt; 'Test Product']]),
    'status' =&gt; 'pending'
];

$stmt = $conn-&gt;prepare("INSERT INTO checkout_details 
    (user_id, full_name, phone, address_line1, address_line2, city, postal_code, payment_method, cart_items, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
$stmt-&gt;bind_param("isssssssss",
    $test_data['user_id'],
    $test_data['full_name'],
    $test_data['phone'],
    $test_data['address_line1'],
    $test_data['address_line2'],
    $test_data['city'],
    $test_data['postal_code'],
    $test_data['payment_method'],
    $test_data['cart_items'],
    $test_data['status']
);

if ($stmt-&gt;execute()) {
    echo "&lt;p style='color: green;'&gt;✓ Test insert successful! ID: " . $stmt-&gt;insert_id . "&lt;/p&gt;";
} else {
    echo "&lt;p style='color: red;'&gt;✗ Test insert failed: " . $stmt-&gt;error . "&lt;/p&gt;";
}
$stmt-&gt;close();
*/

$conn-&gt;close();
?&gt;

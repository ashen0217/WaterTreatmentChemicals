<?php
/**
 * Admin Helper Functions
 * Database operations for admin panel
 */

require_once __DIR__ . '/../../config.php';

// ==================== USER FUNCTIONS ====================

/**
 * Get all users with pagination
 */
function get_all_users($page = 1, $per_page = 10, $search = '') {
    $conn = getDatabaseConnection();
    if (!$conn) return ['users' => [], 'total' => 0];
    
    $offset = ($page - 1) * $per_page;
    
    // Build search condition
    $search_condition = '';
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $search_condition = " WHERE full_name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
    }
    
    // Get total count
    $count_result = $conn->query("SELECT COUNT(*) as total FROM users" . $search_condition);
    $total = $count_result->fetch_assoc()['total'];
    
    // Get users
    $sql = "SELECT * FROM users" . $search_condition . " ORDER BY created_at DESC LIMIT $per_page OFFSET $offset";
    $result = $conn->query($sql);
    
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    
    $conn->close();
    
    return ['users' => $users, 'total' => $total];
}

/**
 * Get user by ID
 */
function get_user_by_id($id) {
    $conn = getDatabaseConnection();
    if (!$conn) return null;
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    $stmt->close();
    $conn->close();
    
    return $user;
}

/**
 * Create new user
 */
function create_user($data) {
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'Database connection failed'];
    
    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $data['email']);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $check_stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Email already exists'];
    }
    $check_stmt->close();
    
    // Hash password
    $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
    
    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password_hash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $data['full_name'], $data['email'], $data['phone'], $password_hash);
    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        return ['success' => true, 'message' => 'User created successfully', 'user_id' => $user_id];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Error creating user: ' . $error];
    }
}

/**
 * Update user
 */
function update_user($id, $data) {
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'Database connection failed'];
    
    // Check if email exists for another user
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $check_stmt->bind_param("si", $data['email'], $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $check_stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Email already exists'];
    }
    $check_stmt->close();
    
    // Update user
    if (!empty($data['password'])) {
        // Update with password
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, password_hash = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $data['full_name'], $data['email'], $data['phone'], $password_hash, $id);
    } else {
        // Update without password
        $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $data['full_name'], $data['email'], $data['phone'], $id);
    }
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return ['success' => true, 'message' => 'User updated successfully'];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Error updating user: ' . $error];
    }
}

/**
 * Delete user
 */
function delete_user($id) {
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'Database connection failed'];
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return ['success' => true, 'message' => 'User deleted successfully'];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Error deleting user: ' . $error];
    }
}

// ==================== PRODUCT FUNCTIONS ====================

/**
 * Handle product image upload
 * Returns array with 'success' and 'path' or 'message'
 */
function handle_product_image_upload($file) {
    // Check if file was uploaded
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => true, 'path' => null];
    }
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error'];
    }
    
    // Validate file type using multiple methods for reliability
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    
    // Get file extension
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // Check extension
    if (!in_array($file_extension, $allowed_extensions)) {
        return ['success' => false, 'message' => 'Invalid file extension: .' . $file_extension . '. Only JPG, PNG, GIF, and WebP are allowed'];
    }
    
    // Verify it's actually an image using getimagesize (more reliable than mime_content_type)
    $image_info = @getimagesize($file['tmp_name']);
    if ($image_info === false) {
        return ['success' => false, 'message' => 'Invalid image file. File is corrupted or not a valid image'];
    }
    
    // Check MIME type from getimagesize
    $detected_mime = $image_info['mime'];
    if (!in_array($detected_mime, $allowed_mime_types)) {
        return ['success' => false, 'message' => 'Invalid MIME type detected: ' . $detected_mime . '. Expected: image/jpeg, image/png, image/gif, or image/webp'];
    }
    
    // Validate file size (5MB max)
    $max_size = 5 * 1024 * 1024; // 5MB in bytes
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'File size exceeds 5MB limit'];
    }
    
    // Create upload directory if it doesn't exist
    $upload_dir = __DIR__ . '/../../uploads/products/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
    $upload_path = $upload_dir . $filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return ['success' => true, 'path' => 'uploads/products/' . $filename];
    } else {
        return ['success' => false, 'message' => 'Failed to save uploaded file'];
    }
}

/**
 * Delete product image file
 */
function delete_product_image($image_path) {
    if (empty($image_path)) {
        return true;
    }
    
    $file_path = __DIR__ . '/../../' . $image_path;
    
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    
    return true; // File doesn't exist, consider it deleted
}

/**
 * Get all products with optional filtering
 */
function get_all_products($category = '', $search = '') {
    $conn = getDatabaseConnection();
    if (!$conn) return [];
    
    $conditions = ["is_active = 1"];
    
    if (!empty($category)) {
        $category = $conn->real_escape_string($category);
        $conditions[] = "category = '$category'";
    }
    
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $conditions[] = "(name LIKE '%$search%' OR description LIKE '%$search%')";
    }
    
    $where = implode(' AND ', $conditions);
    $sql = "SELECT * FROM products WHERE $where ORDER BY category, name";
    $result = $conn->query($sql);
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    $conn->close();
    
    return $products;
}

/**
 * Get product by ID
 */
function get_product_by_id($id) {
    $conn = getDatabaseConnection();
    if (!$conn) return null;
    
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    $stmt->close();
    $conn->close();
    
    return $product;
}

/**
 * Create new product
 */
function create_product($data) {
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'Database connection failed'];
    
    $stmt = $conn->prepare("INSERT INTO products (name, formula, category, form, purity, description, image_path, price_index, effectiveness) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssii", 
        $data['name'], 
        $data['formula'], 
        $data['category'], 
        $data['form'], 
        $data['purity'], 
        $data['description'],
        $data['image_path'], 
        $data['price_index'], 
        $data['effectiveness']
    );
    
    if ($stmt->execute()) {
        $product_id = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        return ['success' => true, 'message' => 'Product created successfully', 'product_id' => $product_id];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Error creating product: ' . $error];
    }
}

/**
 * Update product
 */
function update_product($id, $data) {
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'Database connection failed'];
    
    // If new image is provided, delete old image
    if (isset($data['image_path']) && !empty($data['image_path'])) {
        // Get current product to retrieve old image path
        $old_product = get_product_by_id($id);
        if ($old_product && !empty($old_product['image_path'])) {
            delete_product_image($old_product['image_path']);
        }
    }
    
    $stmt = $conn->prepare("UPDATE products SET name = ?, formula = ?, category = ?, form = ?, purity = ?, description = ?, image_path = ?, price_index = ?, effectiveness = ? WHERE id = ?");
    $stmt->bind_param("ssssssssii", 
        $data['name'], 
        $data['formula'], 
        $data['category'], 
        $data['form'], 
        $data['purity'], 
        $data['description'],
        $data['image_path'], 
        $data['price_index'], 
        $data['effectiveness'],
        $id
    );
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return ['success' => true, 'message' => 'Product updated successfully'];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Error updating product: ' . $error];
    }
}

/**
 * Delete product
 */
function delete_product($id) {
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'Database connection failed'];
    
    // Get product to retrieve image path before deletion
    $product = get_product_by_id($id);
    
    // Soft delete - mark as inactive
    $stmt = $conn->prepare("UPDATE products SET is_active = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Delete associated image file
        if ($product && !empty($product['image_path'])) {
            delete_product_image($product['image_path']);
        }
        
        $stmt->close();
        $conn->close();
        return ['success' => true, 'message' => 'Product deleted successfully'];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Error deleting product: ' . $error];
    }
}

// ==================== DASHBOARD FUNCTIONS ====================

/**
 * Get dashboard statistics
 */
function get_dashboard_stats() {
    $conn = getDatabaseConnection();
    if (!$conn) return [];
    
    $stats = [];
    
    // Total users
    $result = $conn->query("SELECT COUNT(*) as count FROM users WHERE is_active = 1");
    $stats['total_users'] = $result->fetch_assoc()['count'];
    
    // Total products
    $result = $conn->query("SELECT COUNT(*) as count FROM products WHERE is_active = 1");
    $stats['total_products'] = $result->fetch_assoc()['count'];
    
    // Recent signups (last 7 days)
    $result = $conn->query("SELECT COUNT(*) as count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stats['recent_signups'] = $result->fetch_assoc()['count'];
    
    // Recent users
    $result = $conn->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5");
    $stats['recent_users'] = [];
    while ($row = $result->fetch_assoc()) {
        $stats['recent_users'][] = $row;
    }
    
    $conn->close();
    
    return $stats;
}

// ==================== CHECKOUT FUNCTIONS ====================

/**
 * Get checkout statistics
 */
function get_checkout_stats() {
    $conn = getDatabaseConnection();
    if (!$conn) return ['total' => 0, 'pending' => 0, 'approved' => 0, 'ignored' => 0];
    
    $stats = [];
    
    // Total checkouts
    $result = $conn->query("SELECT COUNT(*) as count FROM checkout_details");
    $stats['total'] = $result->fetch_assoc()['count'];
    
    // Pending checkouts
    $result = $conn->query("SELECT COUNT(*) as count FROM checkout_details WHERE status = 'pending'");
    $stats['pending'] = $result->fetch_assoc()['count'];
    
    // Approved checkouts
    $result = $conn->query("SELECT COUNT(*) as count FROM checkout_details WHERE status = 'approved'");
    $stats['approved'] = $result->fetch_assoc()['count'];
    
    // Ignored checkouts
    $result = $conn->query("SELECT COUNT(*) as count FROM checkout_details WHERE status = 'ignored'");
    $stats['ignored'] = $result->fetch_assoc()['count'];
    
    $conn->close();
    
    return $stats;
}

/**
 * Get all checkouts with optional status filter
 */
function get_all_checkouts($status = null) {
    $conn = getDatabaseConnection();
    if (!$conn) return [];
    
    $sql = "SELECT c.*, u.email as user_email 
            FROM checkout_details c 
            LEFT JOIN users u ON c.user_id = u.id";
    
    if ($status && in_array($status, ['pending', 'approved', 'ignored'])) {
        $status = $conn->real_escape_string($status);
        $sql .= " WHERE c.status = '$status'";
    }
    
    $sql .= " ORDER BY c.created_at DESC";
    
    $result = $conn->query($sql);
    
    $checkouts = [];
    while ($row = $result->fetch_assoc()) {
        // Decode cart items JSON
        $row['cart_items_decoded'] = json_decode($row['cart_items'], true);
        $checkouts[] = $row;
    }
    
    $conn->close();
    
    return $checkouts;
}

/**
 * Get checkout by ID
 */
function get_checkout_by_id($id) {
    $conn = getDatabaseConnection();
    if (!$conn) return null;
    
    $stmt = $conn->prepare("SELECT c.*, u.email as user_email, u.full_name as user_full_name 
                            FROM checkout_details c 
                            LEFT JOIN users u ON c.user_id = u.id 
                            WHERE c.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $checkout = $result->fetch_assoc();
    
    if ($checkout) {
        // Decode cart items JSON
        $checkout['cart_items_decoded'] = json_decode($checkout['cart_items'], true);
    }
    
    $stmt->close();
    $conn->close();
    
    return $checkout;
}

/**
 * Update checkout status
 */
function update_checkout_status($id, $status, $notes = '') {
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'Database connection failed'];
    
    // Validate status
    if (!in_array($status, ['pending', 'approved', 'ignored'])) {
        $conn->close();
        return ['success' => false, 'message' => 'Invalid status'];
    }
    
    $stmt = $conn->prepare("UPDATE checkout_details SET status = ?, admin_notes = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $notes, $id);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return ['success' => true, 'message' => 'Checkout status updated successfully'];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Error updating status: ' . $error];
    }
}

// ==================== CONTACT FUNCTIONS ====================

/**
 * Get all contacts with optional status filter
 */
function get_all_contacts($status_filter = null) {
    $conn = getDatabaseConnection();
    if (!$conn) return [];
    
    $sql = "SELECT * FROM contacts";
    
    if ($status_filter && in_array($status_filter, ['pending', 'resolved'])) {
        $sql .= " WHERE status = '" . $conn->real_escape_string($status_filter) . "'";
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $result = $conn->query($sql);
    $contacts = [];
    
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
    
    $conn->close();
    
    return $contacts;
}

/**
 * Get contact statistics
 */
function get_contact_stats() {
    $conn = getDatabaseConnection();
    if (!$conn) return ['total' => 0, 'pending' => 0, 'resolved' => 0];
    
    $stats = ['total' => 0, 'pending' => 0, 'resolved' => 0];
    
    // Get total count
    $result = $conn->query("SELECT COUNT(*) as count FROM contacts");
    $stats['total'] = $result->fetch_assoc()['count'];
    
    // Get pending count
    $result = $conn->query("SELECT COUNT(*) as count FROM contacts WHERE status = 'pending'");
    $stats['pending'] = $result->fetch_assoc()['count'];
    
    // Get resolved count
    $result = $conn->query("SELECT COUNT(*) as count FROM contacts WHERE status = 'resolved'");
    $stats['resolved'] = $result->fetch_assoc()['count'];
    
    $conn->close();
    
    return $stats;
}

/**
 * Get contact by ID
 */
function get_contact_by_id($id) {
    $conn = getDatabaseConnection();
    if (!$conn) return null;
    
    $stmt = $conn->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $contact = $result->fetch_assoc();
    
    $stmt->close();
    $conn->close();
    
    return $contact;
}

/**
 * Update contact status
 */
function update_contact_status($id, $status) {
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'Database connection failed'];
    
    // Validate status
    if (!in_array($status, ['pending', 'resolved'])) {
        $conn->close();
        return ['success' => false, 'message' => 'Invalid status'];
    }
    
    $stmt = $conn->prepare("UPDATE contacts SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return ['success' => true, 'message' => 'Contact status updated successfully'];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return ['success' => false, 'message' => 'Error updating status: ' . $error];
    }
}
?>

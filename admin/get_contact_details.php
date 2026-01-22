<?php
/**
 * Get Contact Details (AJAX endpoint)
 * Returns contact details as JSON
 */
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';

// Require admin authentication
require_admin();

header('Content-Type: application/json');

try {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if (!$id) {
        throw new Exception('Invalid contact ID');
    }
    
    $contact = get_contact_by_id($id);
    
    if (!$contact) {
        throw new Exception('Contact not found');
    }
    
    echo json_encode([
        'success' => true,
        'contact' => $contact
    ]);
    
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

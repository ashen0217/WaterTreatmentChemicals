<?php
/**
 * Process Contact Actions (Update Status)
 * Handles admin actions on contact messages
 */
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';

// Require admin authentication
require_admin();

header('Content-Type: application/json');

try {
    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action === 'update_status') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        
        if (!$id) {
            throw new Exception('Invalid contact ID');
        }
        
        if (!in_array($status, ['pending', 'resolved'])) {
            throw new Exception('Invalid status');
        }
        
        $result = update_contact_status($id, $status);
        
        if ($result['success']) {
            echo json_encode([
                'success' => true,
                'message' => $result['message']
            ]);
        } else {
            throw new Exception($result['message']);
        }
    } else {
        throw new Exception('Invalid action');
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

<?php
/**
 * Process Checkout Action
 * Handles approve/ignore actions from admin
 */
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';

// Require admin authentication
require_admin();

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit();
}

if (!isset($_POST['id']) || !isset($_POST['status'])) {
    $response['message'] = 'Missing required parameters';
    echo json_encode($response);
    exit();
}

$id = intval($_POST['id']);
$status = $_POST['status'];
$notes = isset($_POST['notes']) ? $_POST['notes'] : '';

$result = update_checkout_status($id, $status, $notes);

echo json_encode($result);
?>

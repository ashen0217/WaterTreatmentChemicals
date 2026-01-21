<?php
/**
 * Get Checkout Details API
 * Returns checkout details as JSON for AJAX requests
 */
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';

// Require admin authentication
require_admin();

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (!isset($_GET['id'])) {
    $response['message'] = 'Checkout ID is required';
    echo json_encode($response);
    exit();
}

$id = intval($_GET['id']);
$checkout = get_checkout_by_id($id);

if ($checkout) {
    $response['success'] = true;
    $response['checkout'] = $checkout;
} else {
    $response['message'] = 'Checkout not found';
}

echo json_encode($response);
?>

<?php
session_start();

header('Content-Type: application/json');

// Include the PaymentController
require_once '../controllers/PaymentController.php';

// Ensure the user is logged in (optional, depending on your requirements)
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized access. You must be logged in to perform this action.',
    ]);
    exit();
}

// Validate input
if (!isset($_POST['invoice_number']) || !isset($_POST['status'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing invoice number or status.',
    ]);
    exit();
}

// Get POST data
$invoice_number = $_POST['invoice_number'];
$status = $_POST['status'];

// Update payment status in the database
$paymentController = new PaymentController();
$payment_updated = $paymentController->updatePaymentStatus($invoice_number, $status);

if ($payment_updated) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Payment status updated successfully.',
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to update payment status in the database.',
    ]);
}

<?php

session_start();

require_once '../controllers/PaymentController.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

if (!isset($_POST['contractor_id']) || !isset($_POST['amount'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$freelancer_id = $_SESSION['user_id'];
$contractor_id = $_POST['contractor_id'];
$amount = $_POST['amount'];
$amount = floatval($amount);
$invoice_number = 'INV' . rand(100000, 999999) . time();

$paymentController = new PaymentController();

$payment = $paymentController->initiatePayment($invoice_number, $contractor_id, $freelancer_id, $amount);

if ($payment) {
    echo json_encode(['status' => 'success', 'message' => 'Payment initiated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to initiate payment']);
}
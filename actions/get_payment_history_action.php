<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/PaymentController.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['user_type'];

$paymentController = new PaymentController();

$payments = $paymentController->viewPaymentHistory($user_id, $role);

if ($payments) {
    echo json_encode(['status' => 'success', 'data' => $payments]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch payment history']);
}
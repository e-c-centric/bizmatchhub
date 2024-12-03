<?php
session_start();

header('Content-Type: application/json');

require_once '../controllers/PaymentController.php';

define('PAYSTACK_SECRET_KEY', 'sk_test_06a22baf4e7b63c39fc57d7949989e10e3b06032');

function verify_paystack_transaction($reference)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.paystack.co/transaction/verify/' . urlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . PAYSTACK_SECRET_KEY,
            'Cache-Control: no-cache',
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return [
            'status' => false,
            'message' => 'cURL Error #: ' . $err,
        ];
    } else {
        return json_decode($response, true);
    }
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized access. You must be logged in to complete the payment.',
    ]);
    exit();
}

if (!isset($_POST['transaction_ref']) || !isset($_POST['invoice_number'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing payment reference or invoice number.',
    ]);
    exit();
}

$reference = $_POST['transaction_ref'];
$invoice_number = $_POST['invoice_number'];

$verification_response = verify_paystack_transaction($reference);

if ($verification_response['status'] && $verification_response['data']['status'] === 'success') {
    $paid_amount = $verification_response['data']['amount'] / 100; // Convert amount to GHS
    $currency = $verification_response['data']['currency'];
    $customer_email = $verification_response['data']['customer']['email'];

    $paymentController = new PaymentController();
    $payment_updated = $paymentController->updatePaymentStatus($invoice_number, 'paid');

    if ($payment_updated) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Payment verified and updated successfully.',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update payment status in the database.',
        ]);
    }
} else {
    // Verification failed
    $error_message = isset($verification_response['message']) ? $verification_response['message'] : 'Payment verification failed.';

    echo json_encode([
        'status' => 'error',
        'message' => $error_message,
    ]);
}
?>
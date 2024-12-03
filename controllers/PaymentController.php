<?php
require_once '../classes/PaymentModel.php';

class PaymentController
{
    private $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
    }

    public function initiatePayment(string $invoiceNumber, int $contractorId, int $freelancerId, float $amount): int
    {
        return $this->paymentModel->createPayment($invoiceNumber, $contractorId, $freelancerId, $amount, 'pending');
    }

    public function viewPayment(string $invoiceNumber): array
    {
        return $this->paymentModel->getPaymentByInvoiceNumber($invoiceNumber);
    }

    public function viewPaymentHistory(int $userId, string $userType): array
    {
        return $this->paymentModel->getPaymentsByUserId($userId, $userType);
    }

    public function updatePaymentStatus(string $invoiceNumber, string $status): bool
    {
        return $this->paymentModel->updatePaymentStatus($invoiceNumber, $status);
    }
}

<?php
require_once '../settings/db_class.php';

class PaymentModel extends db_connection
{

    public function createPayment(string $invoiceNumber, int $contractorId, int $freelancerId, float $amount, string $status): int
    {
        if (!$this->db_connect()) {
            return 0;
        }

        $invoiceNumber = mysqli_real_escape_string($this->db, $invoiceNumber);
        $contractorId = intval($contractorId);
        $freelancerId = intval($freelancerId);
        $amount = floatval($amount);
        $status = mysqli_real_escape_string($this->db, $status);

        $sql = "INSERT INTO Payments (invoice_number, contractor_id, freelancer_id, amount, status) 
                VALUES ('$invoiceNumber', $contractorId, $freelancerId, $amount, '$status')";

        if ($this->db_query($sql)) {
            return mysqli_insert_id($this->db);
        }
        return 0;
    }

    public function updatePaymentStatus(string $invoiceNumber, string $status): bool
    {
        if (!$this->db_connect()) {
            return false;
        }

        $invoiceNumber = mysqli_real_escape_string($this->db, $invoiceNumber);
        $status = mysqli_real_escape_string($this->db, $status);

        $sql = "UPDATE Payments SET status = '$status' WHERE invoice_number = '$invoiceNumber'";
        return $this->db_query($sql);
    }

    public function getPaymentByInvoiceNumber(string $invoiceNumber): array
    {
        $invoiceNumber = mysqli_real_escape_string($this->db, $invoiceNumber);
        $sql = "SELECT * FROM Payments WHERE invoice_number = '$invoiceNumber'";
        $result = $this->db_fetch_one($sql);
        return $result ? $result : [];
    }


    public function getPaymentsByUserId(int $userId, string $userType): array
    {
        $userId = intval($userId);
        $userType = intval($userType);

        if ($userType === 'contractor') {
            $sql = "SELECT p.*, u.name as name
                    FROM payments p
                    JOIN users u ON p.freelancer_id = u.user_id
                    WHERE contractor_id = $userId";
        } else {
            $sql = "SELECT p.*, u.name as name
                    FROM payments p
                    JOIN users u ON p.contractor_id = u.user_id
                    WHERE freelancer_id = $userId";
        }

        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }
}

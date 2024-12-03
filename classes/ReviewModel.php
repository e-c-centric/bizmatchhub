<?php
require_once '../settings/db_class.php';

class ReviewModel extends db_connection
{

    public function createReview(int $contractorId, int $freelancerId, int $rating, string $review): int
    {
        if (!$this->db_connect()) {
            return 0;
        }

        $contractorId = intval($contractorId);
        $freelancerId = intval($freelancerId);
        $rating = intval($rating);
        $review = mysqli_real_escape_string($this->db, $review);

        if ($rating < 1 || $rating > 5) {
            return 0;
        }

        $sql = "INSERT INTO Reviews (contractor_id, freelancer_id, rating, review) 
                VALUES ($contractorId, $freelancerId, $rating, '$review')";

        if ($this->db_query($sql)) {
            return mysqli_insert_id($this->db);
        }
        return 0;
    }

    public function getReviewsByFreelancerId(int $freelancerId): array
    {
        $freelancerId = intval($freelancerId);
        $sql = "SELECT * FROM Reviews WHERE freelancer_id = $freelancerId ORDER BY created_at DESC";
        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }

    public function getAverageRating(int $freelancerId): float
    {
        $freelancerId = intval($freelancerId);
        $sql = "SELECT AVG(rating) as average_rating FROM Reviews WHERE freelancer_id = $freelancerId";
        $result = $this->db_fetch_one($sql);
        return $result && $result['average_rating'] ? floatval($result['average_rating']) : 0.0;
    }

    public function deleteReview(int $reviewId): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $reviewId = intval($reviewId);
        $sql = "DELETE FROM Reviews WHERE review_id = $reviewId";
        return $this->db_query($sql);
    }
}

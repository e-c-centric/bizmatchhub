<?php
require_once '../classes/ReviewModel.php';

class ReviewController
{
    private $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }

    public function addReview(int $contractorId, int $freelancerId, int $rating, string $review): int
    {
        return $this->reviewModel->createReview($contractorId, $freelancerId, $rating, $review);
    }

    public function viewReviews(int $freelancerId): array
    {
        return $this->reviewModel->getReviewsByFreelancerId($freelancerId);
    }

    
}

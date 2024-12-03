<?php
require_once '../classes/FreelancerModel.php';

class FreelancerController
{
    private $freelancerModel;

    public function __construct()
    {
        $this->freelancerModel = new FreelancerModel();
    }

    public function createFreelancer(int $userId, int $workExperience, string $jobTitle, string $introduction, float $hourlyRate, string $workHours): bool
    {
        return $this->freelancerModel->createFreelancer($userId, $workExperience, $jobTitle, $introduction, $hourlyRate, $workHours);
    }

    public function getFreelancer(int $freelancerId): array
    {
        return $this->freelancerModel->getFreelancerById($freelancerId);
    }

    public function getFreelancers(): array
    {
        return $this->freelancerModel->getFreelancers();
    }

    public function updateFreelancer(int $freelancerId, int $workExperience, string $jobTitle, string $introduction, float $hourlyRate, string $workHours): bool
    {
        return $this->freelancerModel->updateFreelancer($freelancerId, $workExperience, $jobTitle, $introduction, $hourlyRate, $workHours);
    }

    public function findFreelancersByCategory(int $categoryId, string $experienceLevel = null): array
    {
        return $this->freelancerModel->getFreelancersByCategory($categoryId, $experienceLevel);
    }

    public function findFreelancersByRating(float $minRating, int $minReviews): array
    {
        return $this->freelancerModel->getFreelancersByRating($minRating, $minReviews);
    }

    public function deleteFreelancer(int $freelancerId): bool
    {
        return $this->freelancerModel->deleteFreelancer($freelancerId);
    }

    public function addCategory(int $freelancerId, int $categoryId, string $experienceLevel): bool
    {
        return $this->freelancerModel->addCategory($freelancerId, $categoryId, $experienceLevel);
    }

    public function getCategories(int $freelancerId): array
    {
        return $this->freelancerModel->getCategories($freelancerId);
    }

    public function addPortfolio(int $freelancerId, string $title, string $description, string $url): bool
    {
        return $this->freelancerModel->addPortfolio($freelancerId, $title, $description, $url);
    }

    public function getPortfolios(int $freelancerId): array
    {
        return $this->freelancerModel->getPortfolios($freelancerId);
    }
}

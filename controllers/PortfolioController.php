<?php
require_once '../classes/PortfolioModel.php';

class PortfolioController
{
    private $portfolioModel;

    public function __construct()
    {
        $this->portfolioModel = new PortfolioModel();
    }

    public function addPortfolio(int $freelancerId, string $title, string $description, string $url): int
    {
        return $this->portfolioModel->createPortfolio($freelancerId, $title, $description, $url);
    }

    public function viewPortfolios(int $freelancerId): array
    {
        return $this->portfolioModel->getPortfoliosByFreelancerId($freelancerId);
    }

    public function deletePortfolio(int $portfolioId): bool
    {
        return $this->portfolioModel->deletePortfolio($portfolioId);
    }
}

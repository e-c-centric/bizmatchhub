<?php
require_once '../settings/db_class.php';

class PortfolioModel extends db_connection
{

    public function createPortfolio(int $freelancerId, string $title, string $description, string $url): int
    {
        if (!$this->db_connect()) {
            return 0;
        }
        $freelancerId = intval($freelancerId);
        $title = mysqli_real_escape_string($this->db, $title);
        $description = mysqli_real_escape_string($this->db, $description);
        $url = mysqli_real_escape_string($this->db, $url);

        $sql = "INSERT INTO Portfolios (freelancer_id, title, description, url) 
                VALUES ($freelancerId, '$title', '$description', '$url')";

        if ($this->db_query($sql)) {
            return mysqli_insert_id($this->db);
        }
        return 0;
    }

    public function getPortfoliosByFreelancerId(int $freelancerId): array
    {
        $freelancerId = intval($freelancerId);
        $sql = "SELECT * FROM Portfolios WHERE freelancer_id = $freelancerId";
        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }

    public function deletePortfolio(int $portfolioId): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $portfolioId = intval($portfolioId);
        $sql = "DELETE FROM Portfolios WHERE portfolio_id = $portfolioId";
        return $this->db_query($sql);
    }
}

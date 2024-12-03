<?php
require_once '../settings/db_class.php';

class FreelancerModel extends db_connection
{

    public function createFreelancer(int $userId, int $workExperience, string $jobTitle, string $introduction, float $hourlyRate, string $workHours): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $userId = intval($userId);
        $workExperience = intval($workExperience);
        $jobTitle = mysqli_real_escape_string($this->db, $jobTitle);
        $introduction = mysqli_real_escape_string($this->db, $introduction);
        $hourlyRate = floatval($hourlyRate);
        $workHours = mysqli_real_escape_string($this->db, $workHours);

        $sql = "INSERT INTO FreelancerDetails (freelancer_id, work_experience, job_title, introduction, hourly_rate, work_hours) 
                VALUES ($userId, $workExperience, '$jobTitle', '$introduction', $hourlyRate, '$workHours')";

        return $this->db_query($sql);
    }

    // public function getFreelancerById(int $freelancerId): array
    // {
    //     $freelancerId = intval($freelancerId);
    //     $sql = "SELECT * FROM FreelancerDetails WHERE freelancer_id = $freelancerId";
    //     $result = $this->db_fetch_one($sql);
    //     return $result ? $result : [];
    // }

    public function updateFreelancer(int $freelancerId, int $workExperience, string $jobTitle, string $introduction, float $hourlyRate, string $workHours): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $freelancerId = intval($freelancerId);
        $workExperience = intval($workExperience);
        $jobTitle = mysqli_real_escape_string($this->db, $jobTitle);
        $introduction = mysqli_real_escape_string($this->db, $introduction);
        $hourlyRate = floatval($hourlyRate);
        $workHours = mysqli_real_escape_string($this->db, $workHours);

        $sql = "UPDATE FreelancerDetails 
                SET work_experience = $workExperience, 
                    job_title = '$jobTitle', 
                    introduction = '$introduction', 
                    hourly_rate = $hourlyRate, 
                    work_hours = '$workHours' 
                WHERE freelancer_id = $freelancerId";

        return $this->db_query($sql);
    }

    public function getFreelancersByCategory(int $categoryId, string $experienceLevel = null): array
    {
        $categoryId = intval($categoryId);
        $sql = "SELECT fd.* FROM FreelancerDetails fd 
                JOIN UserCategories uc ON fd.freelancer_id = uc.user_id 
                WHERE uc.category_id = $categoryId";

        if ($experienceLevel) {
            $experienceLevel = mysqli_real_escape_string($this->db, $experienceLevel);
            $minExperience = $this->mapExperienceLevel($experienceLevel);
            $sql .= " AND fd.work_experience >= $minExperience";
        }

        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }

    public function getFreelancersByRating(float $minRating, int $minReviews): array
    {
        $minRating = floatval($minRating);
        $minReviews = intval($minReviews);
        $sql = "SELECT * FROM FreelancerDetails 
                WHERE total_rating >= $minRating AND num_ratings >= $minReviews";
        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }

    private function mapExperienceLevel(string $level): int
    {
        $levels = [
            'beginner' => 1,
            'intermediate' => 2,
            'expert' => 3
        ];
        return $levels[strtolower($level)] ?? 0;
    }

    public function deleteFreelancer(int $freelancerId): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $freelancerId = intval($freelancerId);
        $sql = "DELETE FROM FreelancerDetails WHERE freelancer_id = $freelancerId";
        return $this->db_query($sql);
    }

    public function addCategory(int $freelancerId, int $categoryId, string $experienceLevel): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $freelancerId = intval($freelancerId);
        $categoryId = intval($categoryId);
        $experienceLevel = mysqli_real_escape_string($this->db, $experienceLevel);

        $checkSql = "SELECT 1 FROM FreelancerCategories WHERE freelancer_id = $freelancerId AND category_id = $categoryId LIMIT 1";
        $result = mysqli_query($this->db, $checkSql);

        if ($result && mysqli_num_rows($result) > 0) {
            return true;
        }

        $sql = "INSERT INTO FreelancerCategories (freelancer_id, category_id, experience_level) 
            VALUES ($freelancerId, $categoryId, '$experienceLevel')";

        return $this->db_query($sql);
    }

    public function getCategories(int $freelancerId): array
    {
        if (!$this->db_connect()) {
            return false;
        }
        $freelancerId = intval($freelancerId);
        $sql = "SELECT fc.*, c.name FROM FreelancerCategories fc 
                JOIN Categories c ON fc.category_id = c.category_id 
                WHERE fc.freelancer_id = $freelancerId";
        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }

    public function addPortfolio(int $freelancerId, string $title, string $description, string $url): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $freelancerId = intval($freelancerId);
        $title = mysqli_real_escape_string($this->db, $title);
        $description = mysqli_real_escape_string($this->db, $description);
        $url = mysqli_real_escape_string($this->db, $url);

        $sql = "INSERT INTO Portfolios (freelancer_id, title, description, url) 
                VALUES ($freelancerId, '$title', '$description', '$url')";

        return $this->db_query($sql);
    }

    public function getPortfolios(int $freelancerId): array
    {
        if (!$this->db_connect()) {
            return false;
        }
        $freelancerId = intval($freelancerId);
        $sql = "SELECT * FROM Portfolios WHERE freelancer_id = $freelancerId";
        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }
    public function getFreelancers($category_id = null): array
    {
        if (!$this->db_connect()) {
            // Return an empty array instead of false to maintain return type consistency
            return [];
        }

        // SQL query to fetch freelancer details along with their categories and portfolios
        $sql = "SELECT 
                    frd.freelancer_id, 
                    frd.work_experience, 
                    frd.job_title, 
                    frd.introduction, 
                    frd.total_rating, 
                    frd.num_ratings, 
                    frd.hourly_rate, 
                    frd.work_hours, 
                    frc.category_id, 
                    frc.experience_level, 
                    u.email, 
                    u.phone_number, 
                    u.name, 
                    u.profile_picture,
                    p.portfolio_id, 
                    p.title, 
                    p.description, 
                    p.url,
                    c.name AS category_name
                FROM freelancerdetails frd 
                LEFT JOIN freelancercategories frc ON frd.freelancer_id = frc.freelancer_id
                JOIN users u ON u.user_id = frd.freelancer_id
                LEFT JOIN portfolios p ON frd.freelancer_id = p.freelancer_id
                JOIN categories c ON c.category_id = frc.category_id";

        // Append WHERE clause if a specific category ID is provided
        if ($category_id) {
            $category_id = intval($category_id); // Sanitize input
            $sql .= " WHERE frc.category_id = $category_id";
        }

        // Execute the query and fetch all results
        $result = $this->db_fetch_all($sql);

        // If the result is empty or false, return an empty array
        if (!$result || !is_array($result)) {
            return [];
        }

        // Initialize an empty array to hold aggregated freelancers
        $freelancers = [];

        // Iterate through each row in the result set
        foreach ($result as $row) {
            $freelancer_id = $row['freelancer_id'];

            // If this freelancer hasn't been added yet, initialize their data structure
            if (!isset($freelancers[$freelancer_id])) {
                $freelancers[$freelancer_id] = [
                    'freelancer_id'     => $freelancer_id,
                    'work_experience'   => $row['work_experience'],
                    'job_title'         => $row['job_title'],
                    'introduction'      => $row['introduction'],
                    'total_rating'      => $row['total_rating'],
                    'num_ratings'       => $row['num_ratings'], // Number of clients
                    'hourly_rate'       => $row['hourly_rate'],
                    'work_hours'        => $row['work_hours'],
                    'experience_level'  => $row['experience_level'],
                    'email'             => $row['email'],
                    'phone_number'      => $row['phone_number'],
                    'name'              => $row['name'],
                    'profile_picture'   => $row['profile_picture'],
                    'categories'        => [], // To store multiple categories
                    'portfolios'        => []  // To store multiple portfolios
                ];
            }

            // Add category to the freelancer's categories array if not already present
            if ($row['category_id'] && !in_array([
                'category_id'   => $row['category_id'],
                'category_name' => $row['category_name']
            ], $freelancers[$freelancer_id]['categories'])) {
                $freelancers[$freelancer_id]['categories'][] = [
                    'category_id'   => $row['category_id'],
                    'category_name' => $row['category_name']
                ];
            }

            // Add portfolio to the freelancer's portfolios array if not already present
            if ($row['portfolio_id'] && !in_array([
                'portfolio_id' => $row['portfolio_id'],
                'title'        => $row['title'],
                'description'  => $row['description'],
                'url'          => $row['url']
            ], $freelancers[$freelancer_id]['portfolios'])) {
                $freelancers[$freelancer_id]['portfolios'][] = [
                    'portfolio_id' => $row['portfolio_id'],
                    'title'        => $row['title'],
                    'description'  => $row['description'],
                    'url'          => $row['url']
                ];
            }
        }

        // Reindex the freelancers array to have sequential numeric keys
        return array_values($freelancers);
    }

    public function getFreelancerById($freelancer_id): array
    {
        if (!$this->db_connect()) {
            return false;
        }

        $freelancer_id = intval($freelancer_id);

        // Initialize the response array
        $freelancer = [];

        // 1. Fetch Freelancer's Main Details
        $sql_freelancer = "
            SELECT 
                frd.freelancer_id, 
                frd.work_experience, 
                frd.job_title, 
                frd.introduction, 
                frd.total_rating, 
                frd.num_ratings, 
                frd.hourly_rate, 
                frd.work_hours, 
                u.email, 
                u.phone_number, 
                u.name AS user_name, 
                u.profile_picture
            FROM freelancerdetails frd
            JOIN users u ON u.user_id = frd.freelancer_id
            WHERE frd.freelancer_id = $freelancer_id
            LIMIT 1
        ";

        $result_freelancer = $this->db->query($sql_freelancer);

        if ($result_freelancer && $result_freelancer->num_rows > 0) {
            $freelancer = $result_freelancer->fetch_assoc();
        } else {
            // Freelancer not found
            return [];
        }

        // 2. Fetch Freelancer's Categories
        $sql_categories = "
            SELECT 
                frc.category_id, 
                c.name AS category_name, 
                frc.experience_level
            FROM freelancercategories frc
            JOIN categories c ON c.category_id = frc.category_id
            WHERE frc.freelancer_id = $freelancer_id
        ";

        $result_categories = $this->db->query($sql_categories);
        $categories = [];

        if ($result_categories && $result_categories->num_rows > 0) {
            while ($row = $result_categories->fetch_assoc()) {
                $categories[] = $row;
            }
        }

        $freelancer['categories'] = $categories;

        // 3. Fetch Freelancer's Portfolios
        $sql_portfolios = "
            SELECT 
                portfolio_id, 
                title, 
                description, 
                url
            FROM portfolios 
            WHERE freelancer_id = $freelancer_id
        ";

        $result_portfolios = $this->db->query($sql_portfolios);
        $portfolios = [];

        if ($result_portfolios && $result_portfolios->num_rows > 0) {
            while ($row = $result_portfolios->fetch_assoc()) {
                $portfolios[] = $row;
            }
        }

        $freelancer['portfolios'] = $portfolios;

        return $freelancer;
    }
}

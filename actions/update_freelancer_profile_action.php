<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/FreelancerController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

$freelancer_id = $_SESSION['user_id'];

$freelancerController = new FreelancerController();

#    public function updateFreelancer(int $freelancerId, int $workExperience, string $jobTitle, string $introduction, float $hourlyRate, string $workHours): bool
// {
//     return $this->freelancerModel->updateFreelancer($freelancerId, $workExperience, $jobTitle, $introduction, $hourlyRate, $workHours);
// }

if (!isset($_POST['workExperience']) || !isset($_POST['jobTitle']) || !isset($_POST['introduction']) || !isset($_POST['hourlyRate']) || !isset($_POST['workHours'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit();
}

$workExperience = $_POST['workExperience'];
$jobTitle = $_POST['jobTitle'];
$introduction = $_POST['introduction'];
$hourlyRate = $_POST['hourlyRate'];
$workHours = $_POST['workHours'];

$status = $freelancerController->updateFreelancer($freelancer_id, $workExperience, $jobTitle, $introduction, $hourlyRate, $workHours);

if (!$status) {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
    exit();
}

echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
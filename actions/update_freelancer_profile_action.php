<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/FreelancerController.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit();
}

$freelancer_id = $_SESSION['user_id'];

$freelancerController = new FreelancerController();

if (
    !isset($_POST['workExperience']) ||
    !isset($_POST['jobTitle']) ||
    !isset($_POST['introduction']) ||
    !isset($_POST['hourlyRate']) ||
    !isset($_POST['workHours'])
) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit();
}

$workExperience = intval($_POST['workExperience']);
$jobTitle = trim($_POST['jobTitle']);
$introduction = trim($_POST['introduction']);
$hourlyRate = floatval($_POST['hourlyRate']);
$workHours = trim($_POST['workHours']);

$status = $freelancerController->updateFreelancer($freelancer_id, $workExperience, $jobTitle, $introduction, $hourlyRate, $workHours);

if (!$status) {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
    exit();
}

echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
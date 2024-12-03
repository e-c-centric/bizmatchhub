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

if (!isset($_POST['portfolioTitle']) || !isset($_POST['portfolioDescription']) || !isset($_POST['portfolioURL'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit();
}

$portfolioTitle = $_POST['portfolioTitle'];
$portfolioDescription = $_POST['portfolioDescription'];
$portfolioURL = $_POST['portfolioURL'];

$status = $freelancerController->addPortfolio($freelancer_id, $portfolioTitle, $portfolioDescription, $portfolioURL);

if (!$status) {
    echo json_encode(['success' => false, 'message' => 'Failed to add portfolio.']);
    exit();
}

echo json_encode(['success' => true, 'message' => 'Portfolio added successfully.']);

<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/FreelancerController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

$freelancer_id = $_SESSION['user_id'];
$category_id = $_GET['category'];

$freelancerController = new FreelancerController();

$freelancers = $freelancerController->getFreelancers($category_id);

echo json_encode($freelancers);
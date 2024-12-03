<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/FreelancerController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

$search_id = $_GET['freelancer_id'];

$freelancerController = new FreelancerController();

$freelancers = $freelancerController->getFreelancer($search_id);

echo json_encode($freelancers);
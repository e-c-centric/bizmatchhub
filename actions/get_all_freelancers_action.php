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

$freelancers = $freelancerController->getFreelancer($freelancer_id);

echo json_encode($freelancers);
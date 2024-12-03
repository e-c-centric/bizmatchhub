<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

header('Content-Type: application/json');

require_once '../controllers/UserController.php';

$userController = new UserController();

if (isset($_GET['user_type'])) {
    $users = $userController->viewAllUsers($_GET['user_type']);
} else {
    $users = $userController->viewAllUsers();
}

echo json_encode($users);

<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

header('Content-Type: application/json');

require_once '../controllers/UserController.php';

$userController = new UserController();

$user_id = $_POST['user_id'];

$users = $userController->deactivateAccount($user_id);

if (!$users) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to deactivate user']);
    exit;
}

echo json_encode(['status' => 'success', 'message' => 'User deactivated successfully']);
<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/ChatController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

if (!isset($_POST['receiver_id'])){
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit();
}

$notificationController = new ChatController();

$notifications = $notificationController->viewChatHistory($_SESSION['user_id'], $_POST['receiver_id']);

echo json_encode($notifications);
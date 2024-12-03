<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/ChatController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

$notificationController = new ChatController();

$notifications = $notificationController->getUnreadMessagesCount($_SESSION['user_id']);

echo json_encode($notifications);
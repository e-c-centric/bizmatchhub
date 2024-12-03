<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/ChatController.php';
require_once '../controllers/UserController.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

if (!isset($_POST['receiver_id'])){
    echo json_encode([]);
    exit();
}

$chatController = new ChatController();
$userController = new UserController();

$messages = $chatController->viewChatHistory($_SESSION['user_id'], $_POST['receiver_id']);
$finalMessages = [];

foreach ($messages as $msg) {
    $user = $userController->viewAllUsers();
    foreach ($user as $u) {
        if ($u['user_id'] == $msg['sender_id']) {
            $msg['profile_picture'] = $u['profile_picture'];
            break;
        }
    }
    $finalMessages[] = $msg;
}

echo json_encode($finalMessages);
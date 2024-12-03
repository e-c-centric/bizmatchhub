<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/ChatController.php';
require_once '../controllers/UserController.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$chatController = new ChatController();
$userController = new UserController();

$conversations = $chatController->getAllConversations($_SESSION['user_id']);
$uniqueUsers = [];

foreach ($conversations as $conv) {
    $otherUserId = ($conv['sender_id'] == $_SESSION['user_id']) ? $conv['receiver_id'] : $conv['sender_id'];
    if (!isset($uniqueUsers[$otherUserId])) {
        $user = $userController->viewAllUsers();
        foreach ($user as $u) {
            if ($u['user_id'] == $otherUserId) {
                $uniqueUsers[$otherUserId] = [
                    'sender_id' => $u['user_id'],
                    'sender_username' => $u['name'],
                    'profile_picture' => $u['profile_picture']
                ];
                break;
            }
        }
    }
}

$finalConversations = array_values($uniqueUsers);
echo json_encode($finalConversations);
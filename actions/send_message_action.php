<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/ChatController.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if (!isset($_POST['receiver_id']) || !isset($_POST['message'])){
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit();
}

$receiver_id = intval($_POST['receiver_id']);
$message = trim($_POST['message']) ?? '';

// if($message === ''){
//     echo json_encode(['success' => false, 'message' => 'Message cannot be empty.']);
//     exit();
// }

$chatController = new ChatController();

$messageId = $chatController->sendMessage($_SESSION['user_id'], $receiver_id, $message);

if($messageId){
    echo json_encode(['success' => true, 'message_id' => $messageId]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send message.']);
}
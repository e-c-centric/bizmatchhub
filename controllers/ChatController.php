<?php
require_once '../classes/ChatModel.php';

class ChatController
{
    private $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
    }

    public function sendMessage(int $senderId, int $receiverId, string $message): int
    {
        return $this->chatModel->sendMessage($senderId, $receiverId, $message);
    }

    public function viewChatHistory(int $senderId, int $receiverId): array
    {
        return $this->chatModel->getChatHistory($senderId, $receiverId);
    }

    public function markAsRead(int $chatId): bool
    {
        return $this->chatModel->markAsRead($chatId);
    }

    public function getUnreadMessages(int $receiverId): array
    {
        return $this->chatModel->getUnreadMessages($receiverId);
    }

    public function getUnreadMessagesCount(int $receiverId): int
    {
        return $this->chatModel->getUnreadMessagesCount($receiverId);
    }
}

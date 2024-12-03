<?php
require_once '../settings/db_class.php';

class ChatModel extends db_connection
{

    public function sendMessage(int $senderId, int $receiverId, string $message, $been_read = 0): int
    {
        if (!$this->db_connect()) {
            return 0;
        }

        $senderId = intval($senderId);
        $receiverId = intval($receiverId);
        $message = mysqli_real_escape_string($this->db, $message);
        $been_read = intval($been_read);

        $sql = "INSERT INTO Chats (sender_id, receiver_id, message, been_read)
                VALUES ($senderId, $receiverId, '$message', $been_read)";

        if ($this->db_query($sql)) {
            return mysqli_insert_id($this->db);
        }
        return 0;
    }

    public function getChatHistory(int $senderId, int $receiverId): array
    {
        $senderId = intval($senderId);
        $receiverId = intval($receiverId);

        $sql = "SELECT c.sender_id, c.receiver_id, c.message, c.been_read, c.created_at, u.username as sender_username
                FROM Chats c
                JOIN Users u ON c.sender_id = u.user_id
                WHERE (c.sender_id = $senderId AND c.receiver_id = $receiverId)
                OR (c.sender_id = $receiverId AND c.receiver_id = $senderId)
                ORDER BY c.created_at ASC";


        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }

    public function markAsRead(int $chatId): bool
    {
        $chatId = intval($chatId);

        $sql = "UPDATE Chats SET been_read = 1 WHERE chat_id = $chatId";
        return $this->db_query($sql);
    }

    public function getUnreadMessages(int $receiverId): array
    {
        $receiverId = intval($receiverId);

        $sql = "SELECT * FROM Chats WHERE receiver_id = $receiverId AND been_read = 0";
        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }

    public function getUnreadMessagesCount(int $receiverId): int
    {
        $receiverId = intval($receiverId);
        $sql = "SELECT COUNT(*) AS unread_count FROM Chats WHERE receiver_id = $receiverId AND been_read = 0";

        try {
            $result = $this->db_fetch_one($sql);
            if ($result && isset($result['unread_count'])) {
                return intval($result['unread_count']);
            } else {
                // Log detailed error information for debugging
                error_log("Failed to retrieve unread messages count for receiver_id: $receiverId");
                return 0;
            }
        } catch (Exception $e) {
            // Log exception details
            error_log("Exception in getUnreadMessagesCount: " . $e->getMessage());
            return 0;
        }
    }
}

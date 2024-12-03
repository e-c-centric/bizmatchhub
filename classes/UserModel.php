<?php
require_once '../settings/db_class.php';

class UserModel extends db_connection
{
    public function __construct()
    {
        parent::db_connect();

        if (!$this->db_connect()) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    }

    public function createUser(string $email, string $phone, string $password, string $name, string $userType): int
    {
        parent::db_connect();
        if (!$this->db_connect()) {
            return 0;
        }
        $email = mysqli_real_escape_string($this->db, $email);
        $phone = mysqli_real_escape_string($this->db, $phone);
        $password = password_hash($password, PASSWORD_BCRYPT);
        $name = mysqli_real_escape_string($this->db, $name);
        $userType = mysqli_real_escape_string($this->db, $userType);

        $sql = "INSERT INTO Users (email, phone_number, password, name, user_type) VALUES ('$email', '$phone', '$password', '$name', '$userType')";

        if ($this->db_query($sql)) {
            return mysqli_insert_id($this->db);
        }
        return 0;
    }

    public function getUserById(int $userId): array
    {
        $userId = intval($userId);
        $sql = "SELECT * FROM Users WHERE user_id = $userId";
        $result = $this->db_fetch_one($sql);
        return $result ? $result : [];
    }

    public function getUserByEmail(string $email): array
    {
        $email = mysqli_real_escape_string($this->db, $email);
        $sql = "SELECT * FROM Users WHERE email = '$email'";
        $result = $this->db_fetch_one($sql);
        return $result ? $result : [];
    }

    public function checkOwner(string $email): bool
    {
        $email = mysqli_real_escape_string($this->db, $email);
        $sql = "SELECT * FROM Users JOIN owner ON Users.user_id = owner.owner_id WHERE email = '$email'";
        $result = $this->db_fetch_one($sql);
        return $result ? true : false;
    }

    public function updateUser(int $userId, string $email, string $phone, string $name, ?string $profilePicture): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $userId = intval($userId);
        $email = mysqli_real_escape_string($this->db, $email);
        $phone = mysqli_real_escape_string($this->db, $phone);
        $name = mysqli_real_escape_string($this->db, $name);
        $profilePicture = $profilePicture ? "'" . mysqli_real_escape_string($this->db, $profilePicture) . "'" : "NULL";

        $sql = "UPDATE Users SET email = '$email', phone_number = '$phone', name = '$name', profile_picture = $profilePicture WHERE user_id = $userId";
        return $this->db_query($sql);
    }

    public function deactivateUser(int $userId): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $userId = intval($userId);
        $sql = "UPDATE Users SET is_active = FALSE WHERE user_id = $userId";
        return $this->db_query($sql);
    }

    public function getAllUsers(): array
    {
        if (!$this->db_connect()) {
            return [];
        }
        $sql = "SELECT user_id, email, phone_number, name, user_type, is_active, created_at FROM Users";
        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }
}

<?php
require_once '../classes/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register(string $email, string $phone, string $password, string $name, string $userType): int
    {
        if ($this->userModel->getUserByEmail($email)) {
            return 0;
        }

        return $this->userModel->createUser($email, $phone, $password, $name, $userType);
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userModel->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {


            $_SESSION['user_id'] = $user['user_id'];

            if ($user['user_type'] === 'freelancer') {
                $_SESSION['user_type'] = 1;
            } else if ($user['user_type'] === 'contractor') {
                $_SESSION['user_type'] = 2;
            } else {
                $_SESSION['user_type'] = 3;
            }
            return true;
        }
        return false;
    }

    public function loginOwner(string $email, string $password): bool
    {
        $user = $this->userModel->getUserByEmail($email);
        if ($user && password_verify($password, $user['password']) && $this->userModel->checkOwner($email)) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_type'] = 3;
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
    }

    public function updateProfile(int $userId, string $email, string $phone, string $name, ?string $profilePicture): bool
    {
        return $this->userModel->updateUser($userId, $email, $phone, $name, $profilePicture);
    }

    public function deactivateAccount(int $userId): bool
    {
        return $this->userModel->deactivateUser($userId);
    }

    public function viewAllUsers(string $userType = null): array
    {
        return $this->userModel->getAllUsers($userType);
    }
}

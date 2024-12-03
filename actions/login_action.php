<?php
require_once '../controllers/UserController.php';

header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$rememberMe = isset($_POST['rememberMe']) ? true : false;

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

$userController = new UserController();
$loginSuccess = $userController->login($email, $password);

if ($loginSuccess) {
    echo json_encode(['success' => true, 'message' => 'Login successful!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
}

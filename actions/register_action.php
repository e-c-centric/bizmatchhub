<?php
require_once '../controllers/UserController.php';
require_once '../controllers/FreelancerController.php';

header('Content-Type: application/json');

// Retrieve POST data
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';
$name = $_POST['name'] ?? '';
$userType = $_POST['userType'] ?? '';

// Validate required fields
if (empty($email) || empty($phone) || empty($password) || empty($name) || empty($userType)) {
    echo json_encode(['success' => false, 'message' => 'All required fields must be filled.']);
    exit;
}

$userController = new UserController();
$userId = $userController->register($email, $phone, $password, $name, $userType);

if ($userId > 0) {
    if ($userType === 'freelancer') {
        $workExperience = $_POST['workExperience'] ?? 0;
        $jobTitle = $_POST['jobTitle'] ?? '';
        $introduction = $_POST['introduction'] ?? '';
        $hourlyRate = $_POST['hourlyRate'] ?? 0.0;
        $workHours = $_POST['workHours'] ?? '';

        $freelancerController = new FreelancerController();
        $freelancerCreated = $freelancerController->createFreelancer($userId, $workExperience, $jobTitle, $introduction, $hourlyRate, $workHours);

        if ($freelancerCreated) {
            echo json_encode(['success' => true, 'message' => 'Registration successful as Freelancer!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration successful, but failed to create freelancer profile.']);
        }
    } else {
        echo json_encode(['success' => true, 'message' => 'Registration successful!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed. Email might already be in use.']);
}

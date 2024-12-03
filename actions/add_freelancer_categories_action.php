<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/FreelancerController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

$freelancer_id = $_SESSION['user_id'];

$freelancerController = new FreelancerController();

$selected_categories = isset($_POST['categories']) ? $_POST['categories'] : [];
$experience_levels = isset($_POST['experience_levels']) ? $_POST['experience_levels'] : [];

if (empty($selected_categories)) {
    echo json_encode(['success' => false, 'message' => 'No categories selected.']);
    exit();
}

if (count($selected_categories) !== count($experience_levels)) {
    echo json_encode(['success' => false, 'message' => 'Mismatch between selected categories and experience levels.']);
    exit();
}

$allowed_experience_levels = ['beginner', 'intermediate', 'expert'];


foreach ($selected_categories as $category_id) {
    // Sanitize and validate category_id
    $cat_id = intval($category_id);
    if ($cat_id <= 0) {
        throw new Exception('Invalid category ID.');
    }

    // Check if experience level exists for the category
    if (!isset($experience_levels[$category_id])) {
        throw new Exception('Missing experience level for category ID: ' . $category_id);
    }

    // Sanitize and convert experience level to lowercase
    $exp_level_raw = trim($experience_levels[$category_id]);
    $exp_level = strtolower($exp_level_raw);

    // Validate experience level
    if (!in_array($exp_level, $allowed_experience_levels)) {
        throw new Exception('Invalid experience level for category ID: ' . $category_id);
    }

    $status = $freelancerController->addCategory($freelancer_id, $cat_id, $exp_level);
}

if (!$status) {
    echo json_encode(['success' => false, 'message' => 'Failed to add at least 1 category.']);
    exit();
}

echo json_encode(['success' => true, 'message' => 'Categories added successfully.']);

exit();

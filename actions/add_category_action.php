<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/CategoryController.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

$categoryController = new CategoryController();

if (isset($_POST['category_name']) && isset($_POST['image_url'])) {
    $name = trim($_POST['category_name']);
    $image = trim($_POST['image_url']);
    $createdBy = $_SESSION['user_id'];

    $categoryId = $categoryController->addCategory($name, $createdBy, $image);

    if ($categoryId > 0) {
        echo json_encode(['status' => 'success', 'category_id' => $categoryId]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add category']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input parameters']);
    exit;
}

<?php

session_start();

header('Content-Type: application/json');

require_once '../controllers/CategoryController.php';

$categoryController = new CategoryController();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

if (isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];

    $isDeleted = $categoryController->removeCategory($categoryId);

    if ($isDeleted) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete category']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input parameters']);
    exit;
}
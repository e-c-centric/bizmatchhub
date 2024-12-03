<?php

header('Content-Type: application/json');

require_once '../controllers/CategoryController.php';

$categoryController = new CategoryController();

$categories = $categoryController->viewAllCategories();

echo json_encode($categories);
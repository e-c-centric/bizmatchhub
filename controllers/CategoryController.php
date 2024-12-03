<?php
require_once '../classes/CategoryModel.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function addCategory(string $name, int $createdBy, string $imageSrc): int
    {
        return $this->categoryModel->createCategory($name, $createdBy, $imageSrc);
    }

    public function viewAllCategories(): array
    {
        return $this->categoryModel->getAllCategories();
    }

    public function removeCategory(int $categoryId): bool
    {
        return $this->categoryModel->deleteCategory($categoryId);
    }
}

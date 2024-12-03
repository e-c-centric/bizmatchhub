<?php
require_once '../settings/db_class.php';

class CategoryModel extends db_connection
{

    public function createCategory(string $name, int $createdBy, string $imageSrc): int
    {
        if (!$this->db_connect()) {
            return 0;
        }
        $name = mysqli_real_escape_string($this->db, $name);
        $createdBy = intval($createdBy);
        $imageSrc = mysqli_real_escape_string($this->db, $imageSrc);


        $sql = "INSERT INTO Categories (name, created_by, image) VALUES ('$name', $createdBy, '$imageSrc')";

        if ($this->db_query($sql)) {
            return mysqli_insert_id($this->db);
        }
        return 0;
    }

    public function getAllCategories(): array
    {
        $sql = "SELECT * FROM Categories";
        $result = $this->db_fetch_all($sql);
        return $result ? $result : [];
    }

    public function deleteCategory(int $categoryId): bool
    {
        if (!$this->db_connect()) {
            return false;
        }
        $categoryId = intval($categoryId);
        $sql = "DELETE FROM Categories WHERE category_id = $categoryId";
        return $this->db_query($sql);
    }
}

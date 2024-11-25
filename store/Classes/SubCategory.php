<?php

require_once "Database.php";

class SubCategory
{
    public $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->con;
    }

    // Save Sub Category
    public function save_subcategory($category_id, $sub_category_name, $description, $status)
    {
        $query = "INSERT INTO sub_categories (category_id, sub_category_name, description, status) VALUES (:category_id, :sub_category_name, :description, :status)";
        $sql = $this->pdo->prepare($query);
        $sql->bindParam(":category_id", $category_id);
        $sql->bindParam(":sub_category_name", $sub_category_name);
        $sql->bindParam(":description", $description);
        $sql->bindParam(":status", $status);

        $is_success = $sql->execute();

        return $is_success ? "success" : "Failed";
    }

    // Get Sub Category
    public function get_sub_categories($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT sub_categories.id, sub_categories.sub_category_name, sub_categories.status, sub_categories.description, categories.category_name FROM sub_categories LEFT JOIN categories ON categories.id = sub_categories.category_id  ORDER BY sub_categories.id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $sub_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get total count of categories
        $countQuery = "SELECT COUNT(*) as total FROM sub_categories";
        $countResult = $this->pdo->query($countQuery)->fetch(PDO::FETCH_ASSOC);
        $total = $countResult['total'];

        return ['data' => $sub_categories, 'total' => $total];
    }

    // Get Categroy By id
    public function get_subcategory_by_id($id)
    {
        $query = "SELECT * FROM sub_categories WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result;
    }

    // Update The sub category
    public function update_subcategroy($id, $category_id, $sub_category_name, $description , $status)
    {
        $query = "UPDATE sub_categories SET sub_category_name = :sub_category_name, description =:description,status = :status WHERE id=:id";
        $sql = $this->pdo->prepare($query);
        $sql->bindParam(":sub_category_name", $sub_category_name);
        $sql->bindParam(":description", $description);
        $sql->bindParam(":status", $status);
        $sql->bindParam(":id", $id);

        $is_success = $sql->execute();

        // Update Image if exists
        if ($is_success && !empty($category_id)) {
            // Update the image
            $query = "UPDATE sub_categories SET category_id = :category_id WHERE id = :id";
            $sql = $this->pdo->prepare($query);
            $sql->bindParam(":category_id", $category_id);
            $sql->bindParam(":id", $id);
            $is_success = $sql->execute();
        }

        return $is_success ? "success" : "Failed";
    }

    // Delete Sub Categroy
    public function delete_subcategory($id)
    {
        $query = "DELETE FROM sub_categories WHERE id = :id";
        $sql = $this->pdo->prepare($query);
        $sql->bindParam(":id", $id);
        return $sql->execute();
    }

    // Search Query
    public function search_result($search_query)
    {
        $query = "SELECT * FROM sub_categories LEFT JOIN categories ON categories.id = sub_categories.category_id WHERE sub_category_name LIKE :search_query OR sub_categories.description LIKE :search_query OR category_name LIKE :search_query ORDER BY sub_categories.id DESC";
        $sql = $this->pdo->prepare($query);
        $search_term = "%{$search_query}%";
        $sql->bindParam(":search_query", $search_term);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_cat_subCategroy($category_id) 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM sub_categories WHERE category_id = :category_id");
        $stmt->bindParam(":category_id", $category_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

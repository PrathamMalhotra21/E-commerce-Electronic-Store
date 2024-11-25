<?php

require_once "Database.php";

class Category
{
    private $upload_path = "upload/category";
    public $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->con;
    }

    public function save_category($category_name, $description, $image, $status)
    {
        $file_name = $image["name"];
        $tmp_name = $image["tmp_name"];
        $new_path = $this->upload_path . "/" . uniqid() . "." . pathinfo($file_name, PATHINFO_EXTENSION);

        $query = "INSERT INTO categories (category_name, description, image, status) VALUES (:category_name, :description, :image, :status)";
        $sql = $this->pdo->prepare($query);
        $sql->bindParam(":category_name", $category_name);
        $sql->bindParam(":description", $description);
        $sql->bindParam(":image", $new_path);
        $sql->bindParam(":status", $status);

        $is_success = $sql->execute();

        if ($is_success) {
            move_uploaded_file($tmp_name, "../" . $new_path);
            return "success";
        }

        return "Failed";
    }


    public function get_categories($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM categories ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get total count of categories
        $countQuery = "SELECT COUNT(*) as total FROM categories";
        $countResult = $this->pdo->query($countQuery)->fetch(PDO::FETCH_ASSOC);
        $total = $countResult['total'];

        return ['data' => $categories, 'total' => $total];
    }

    public function get_category_by_id($id)
    {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result;
    }

    public function update_categroy($id, $category_name, $description, $image, $status)
    {
        $query = "UPDATE categories SET category_name = :category_name, description =:description,status = :status WHERE id=:id";
        $sql = $this->pdo->prepare($query);
        $sql->bindParam(":category_name", $category_name);
        $sql->bindParam(":description", $description);
        $sql->bindParam(":status", $status);
        $sql->bindParam(":id", $id);

        $is_success = $sql->execute();

        // Update Image if exists
        if ($is_success && !empty($image['name'])) {
            // Image Name and path
            $file_name = $image["name"];
            $tmp_name = $image["tmp_name"];
            $new_path = $this->upload_path . "/" . uniqid() . "." . pathinfo($file_name, PATHINFO_EXTENSION);

            // Update the image
            $query = "UPDATE categories SET image = :img WHERE id = :id";
            $sql = $this->pdo->prepare($query);
            $sql->bindParam(":img", $new_path);
            $sql->bindParam(":id", $id);

            // Move image
            if ($sql->execute()) {
                move_uploaded_file($tmp_name, "../" . $new_path);
            }
        }

        return $is_success ? "success" : "Failed";
    }

    public function delete_category($id)
    {
        $query = "DELETE FROM categories WHERE id = :id";
        $sql = $this->pdo->prepare($query);
        $sql->bindParam(":id", $id);
        return $sql->execute();
    }

    public function search_result($search_query)
    {
        $query = "SELECT * FROM categories WHERE category_name LIKE :search_query OR description LIKE :search_query ORDER BY id DESC";
        $sql = $this->pdo->prepare($query);
        $search_term = "%{$search_query}%";
        $sql->bindParam(":search_query", $search_term);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_all_category($status = "") 
    {
        $query = "SELECT * FROM categories";
        if ($status != "") {
            $query .= " WHERE categories.status = :status";
        }
        $sql = $this->pdo->prepare($query);
        if ($status != "") {
            $sql->bindParam(":status", $status);
        }
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}

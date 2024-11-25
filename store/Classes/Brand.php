<?php
require_once "Database.php";

class Brand {
    public $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->con;
    }

    public function save_brand($brand_name, $description, $status) 
    {
        $query = "INSERT INTO  brands(brand_name, description, status) VALUES (:brand_name, :description, :status)";
        $sql = $this->pdo->prepare($query);
        $sql->bindParam(":brand_name", $brand_name);
        $sql->bindParam(":description", $description);
        $sql->bindParam(":status", $status);
        return $sql->execute() ? "success" : "falied"; 
    }

    public function get_brand($page = 1, $limit = 10) 
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM brands ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get total count of brands
        $countQuery = "SELECT COUNT(*) as total FROM brands";
        $countResult = $this->pdo->query($countQuery)->fetch(PDO::FETCH_ASSOC);
        $total = $countResult['total'];

        return ['data' => $results, 'total' => $total];
    }

    public function get_brand_by_id($id)
    {
        $query = "SELECT * FROM brands WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }

    public function update_brand($id, $brand_name, $description, $status)
    {
        $query = "UPDATE brands SET brand_name = :brand_name, description =:description,status = :status WHERE id=:id";
        $sql = $this->pdo->prepare($query);
        $sql->bindParam(":brand_name", $brand_name);
        $sql->bindParam(":description", $description);
        $sql->bindParam(":status", $status);
        $sql->bindParam(":id", $id);

        $is_success = $sql->execute();

        return $is_success ? "success" : "Failed";
    }

    public function delete_brand($id)
    {
        $query = "DELETE FROM brands WHERE id = :id";
        $sql = $this->pdo->prepare($query);
        $sql->bindParam(":id", $id);
        return $sql->execute();
    }

    public function search_result($search_query)
    {
        $query = "SELECT * FROM brands WHERE brand_name LIKE :search_query OR description LIKE :search_query ORDER BY id DESC";
        $sql = $this->pdo->prepare($query);
        $search_term = "%{$search_query}%";
        $sql->bindParam(":search_query", $search_term);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}
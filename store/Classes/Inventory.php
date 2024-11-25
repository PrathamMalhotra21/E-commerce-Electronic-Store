<?php

require_once "Database.php";

class Inventory
{
    public $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->con;
    }

    public function save_inventory($product_id, $quantity, $price)
    {
        // Check if inventory already exist or not
        $checkStmt = $this->pdo->prepare("SELECT * FROM inventory WHERE product_id = :product_id");
        $checkStmt->bindParam(":product_id", $product_id);
        $checkStmt->execute();
        $is_exists = $checkStmt->fetch(PDO::FETCH_ASSOC);
        if ($is_exists) {
            return "Product already exist";
        }

        $query = "INSERT INTO inventory (product_id, quantity, price) VALUES (:product_id, :quantity, :price)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(":price", $price);
        $is_executed = $stmt->execute();
        if ($is_executed) { 
            return "Inventory added successfully";
        } else { 
            return "Unable to add inventory";
        }
    }

    public function get_product_id()
    {
        $query = "SELECT id, name FROM products";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_inventory($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT inventory.id, inventory.product_id, products.name, inventory.price, inventory.quantity, inventory.date_created 
                  FROM inventory 
                  LEFT JOIN products ON products.id = inventory.product_id 
                  ORDER BY inventory.id LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count
        $countQuery = "SELECT COUNT(*) AS count FROM inventory";
        $stmtCount = $this->pdo->query($countQuery);
        $count = $stmtCount->fetch(PDO::FETCH_ASSOC);

        return [
            'data' => $result,
            'total' => $count['count']
        ];
    }

    public function get_inventory_id($id)
    {
        $query = "SELECT * FROM inventory WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update_inventory($id, $product_id, $quantity, $price)
    {
        $query = "UPDATE inventory SET product_id = :product_id, quantity = :quantity, price = :price  WHERE id = :id;";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":id", $id);
        $is_executed = $stmt->execute();

        if ($is_executed) { 
            return "Inventory updated successfully";
        } else { 
            return "Unable to update inventory";
        }
    }

    public function delete_inventory($id)
    {
        $query = "DELETE FROM inventory WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute() ? "Inventory Deleted Successfully" : "Unable to delete inventory";
    }

    public function search_inventory($page = 1, $limit = 10, $search = '')
    {
        $offset = ($page - 1) * $limit;

        // Build the query with search conditions
        $query = "SELECT inventory.id, inventory.product_id, products.name, inventory.price, inventory.quantity, inventory.date_created 
              FROM inventory 
              LEFT JOIN products ON products.id = inventory.product_id
              WHERE products.name LIKE :search OR inventory.price LIKE :search OR inventory.quantity LIKE :search
              ORDER BY inventory.id 
              LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($query);

        // Add wildcards for the search term
        $searchTerm = "%" . $search . "%";
        $stmt->bindParam(":search", $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count the total records matching the search query
        $countQuery = "SELECT COUNT(*) AS count FROM inventory 
                   LEFT JOIN products ON products.id = inventory.product_id
                   WHERE products.name LIKE :search OR inventory.price LIKE :search OR inventory.quantity LIKE :search";
        $stmtCount = $this->pdo->prepare($countQuery);
        $stmtCount->bindParam(":search", $searchTerm, PDO::PARAM_STR);
        $stmtCount->execute();
        $count = $stmtCount->fetch(PDO::FETCH_ASSOC);

        return [
            'data' => $result,
            'total' => $count['count']
        ];
    }
}

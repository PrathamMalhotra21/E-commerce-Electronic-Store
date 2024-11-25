<?php
require_once "Database.php";

class Product
{
    public $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->con;
    }

    // Get all ids category, brand, subcategory
    public function get_all_ids()
    {
        $stmt = $this->pdo->prepare("SELECT id, category_name FROM categories");
        $stmt->execute();
        $category = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT id, brand_name FROM brands");
        $stmt->execute();
        $brand = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'category' => $category,
            'brand' => $brand
        ];
    }

    public function get_all_sub_category($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, sub_category_name FROM sub_categories WHERE category_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $sub_category = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sub_category;
    }

    // Save
    public function save_product($name, $specs, $brand_id, $category_id, $sub_category_id, $status, $images)
    {
        $query = "INSERT INTO products (name, specs, brand_id, category_id, sub_category_id, status) VALUES (:name, :specs, :brand_id, :category_id, :sub_category_id, :status)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":specs", $specs);
        $stmt->bindParam(":brand_id", $brand_id);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->bindParam(":sub_category_id", $sub_category_id);
        $stmt->bindParam(":status", $status);
        $stmt->execute();

        $last_inserted_id = $this->pdo->lastInsertId();

        $upload_folder = "../upload/Product_" . $last_inserted_id;

        // Check if folder exist or not
        if (!file_exists($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }

        // Move images to folder
        if ($images && count($images['name']) > 0) {
            foreach ($images['name'] as $key => $value) {
                $file_ex = pathinfo($value, PATHINFO_EXTENSION);

                $new_image_name = $last_inserted_id . "_" . $key . "." . $file_ex;
                $upload_path = $upload_folder . "/" . $new_image_name;

                if (!move_uploaded_file($images['tmp_name'][$key], $upload_path)) {
                    echo "Unable to upload Images";
                    exit();
                }
            }
        }

        return "Product added successfully!";
    }

    // Get
    public function get_all_product($page = 1, $limit = 10, $status = "")
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT products.id, products.name, products.specs, products.brand_id, products.status, brands.brand_name, inventory.price FROM products LEFT JOIN brands ON brands.id = products.brand_id LEFT JOIN inventory ON inventory.product_id = products.id";
        if ($status != "") {
            $query .= " WHERE products.status = :status ";
        }
        $query .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt =  $this->pdo->prepare($query);
        if ($status != "") {
            $stmt->bindParam(":status", $status);
        }
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countQuery = "SELECT COUNT(*) AS count FROM products";
        $count = $this->pdo->query($countQuery)->fetch(PDO::FETCH_ASSOC);

        return [
            'result' => $result,
            'total' => $count['count']
        ];
    }

    public function get_product_id($id)
    {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    // Update 
    public function update_product($id, $name, $specs, $brand_id, $category_id, $sub_category_id, $status, $images)
    {
        // Update query
        $query = "UPDATE products 
          SET name = :name, specs = :specs, brand_id = :brand_id, category_id = :category_id, sub_category_id = :sub_category_id, status = :status 
          WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":specs", $specs);
        $stmt->bindParam(":brand_id", $brand_id);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->bindParam(":sub_category_id", $sub_category_id);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        $is_executed = $stmt->execute();

        // Upload folder
        $upload_folder = "../upload/Product_" . $id;

        // Create directory if it doesn't exist
        if (!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }

        if ($is_executed) {
            // Move images to folder if image is uploaded
            if (!empty($images) && count($images['name']) > 0) {
                foreach ($images['name'] as $key => $value) {
                    // Get the file extension
                    $file_ex = pathinfo($value, PATHINFO_EXTENSION);

                    $new_image_name = uniqid("product_" . $id . "_", true) . "." . $file_ex;
                    $upload_path = $upload_folder . "/" . $new_image_name;

                    if (empty($value)) {
                        return "Product updated successfully";
                    }

                    if (!move_uploaded_file($images['tmp_name'][$key], $upload_path)) {
                        return "Unable to upload image: $value";
                    }
                }
            }
            return "Product updated successfully";
        } else {
            return "Unable to update product";
        }
    }

    public function delete_product($id)
    {
        $upload_path = "../upload/Product_" . $id;
        if (is_dir($upload_path)) {
            // Delete all files in the directory
            $files = array_diff(scandir($upload_path), ['.', '..']);
            foreach ($files as $file) {
                unlink($upload_path . '/' . $file);
            }
            // Remove the directory
            rmdir($upload_path);
        } elseif (file_exists($upload_path)) {
            unlink($upload_path);
        }
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute() ? "Product deleted successfully" : "Unable to delete product successfully";
    }

    public function search_result($vl, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $search = "%$vl%";

        $query = "SELECT products.id, products.name, products.specs, products.brand_id, products.status, brands.brand_name 
                  FROM products 
                  LEFT JOIN brands ON brands.id = products.brand_id 
                  WHERE products.name LIKE :search  
                    OR products.specs LIKE :search  
                    OR brands.brand_name LIKE :search 
                  ORDER BY products.id DESC 
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count
        $countQuery = "SELECT COUNT(*) AS count 
                       FROM products 
                       LEFT JOIN brands ON brands.id = products.brand_id 
                       WHERE products.name LIKE :search  
                         OR products.specs LIKE :search  
                         OR brands.brand_name LIKE :search";

        $countStmt = $this->pdo->prepare($countQuery);
        $countStmt->bindParam(':search', $search, PDO::PARAM_STR);
        $countStmt->execute();
        $count = $countStmt->fetch(PDO::FETCH_ASSOC);

        return [
            'result' => $result,
            'total' => $count['count']
        ];
    }

    // Get All product using brand_id or categroy_id
    public function get_products_by_brand($id) {
        $query = "SELECT products.id, products.name, products.specs, products.brand_id, products.status,inventory.price FROM products LEFT JOIN inventory ON inventory.product_id = products.id WHERE brand_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function get_products_by_category($id, $status = "", $sub_category_id = "") {
        $query = "SELECT products.id, products.name, products.specs, products.brand_id, products.status,inventory.price FROM products LEFT JOIN inventory ON inventory.product_id = products.id WHERE category_id = :id";
        if ($status != "") {
            $query .= " && products.status = :status ";
        }
        if ($sub_category_id != "") {
            $query .= " && products.sub_category_id = :sub_category_id ";
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        if ($status != "") {
            $stmt->bindParam(":status", $status);
        }
        if ($sub_category_id != "") {
            $stmt->bindParam(":sub_category_id", $sub_category_id);
        }
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function get_product($product_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products LEFT JOIN brands ON products.brand_id = brands.id WHERE products.id=:id");
        $stmt->bindParam(":id", $product_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmtInv = $this->pdo->prepare("SELECT * FROM inventory WHERE product_id = :product_id");
        $stmtInv->bindParam(":product_id", $product_id);
        $stmtInv->execute();
        $inventory = $stmtInv->fetch(PDO::FETCH_ASSOC);

        return ['product' => $product, 'inventory' => $inventory];
    }

    public function search_product ($query) 
    {
        $search = "%$query%";
        $stmt = $this->pdo->prepare("SELECT products.id, products.name, products.status,inventory.price FROM products LEFT JOIN inventory ON inventory.product_id = products.id WHERE products.name LIKE :search");
        $stmt->bindParam(":search", $search, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

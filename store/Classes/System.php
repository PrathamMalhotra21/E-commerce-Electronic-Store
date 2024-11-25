<?php
require_once "Database.php";

class System
{
    public $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->con;
    }

    public function save_banner($heading, $title, $badge_text, $btn_text, $image)
    {
        $upload_path = "upload/banner/" . uniqid() . "." . pathinfo($image['name'], PATHINFO_EXTENSION);
        $file_tmp = $image['tmp_name'];

        if (move_uploaded_file($file_tmp, "../" . $upload_path)) {
            $query = "INSERT INTO banner (heading, title, badge_text, btn_text, image) VALUES (:heading, :title, :badge_text, :btn_text, :image)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":heading", $heading);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":badge_text", $badge_text);
            $stmt->bindParam(":btn_text", $btn_text);
            $stmt->bindParam(":image", $upload_path);
            return $stmt->execute() ? "Banner uploaded successfully" : "Unable to upload Banner";
        }

        return "Unable to upload Image";
    }

    public function get_banner()
    {
        $query = "SELECT * FROM banner";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_banner_id($id)
    {
        $query = "SELECT * FROM banner WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update_banner($id, $heading, $title, $badge_text, $btn_text, $image = null)
    {
        $query = "UPDATE banner SET heading = :heading, title = :title, badge_text = :badge_text, btn_text = :btn_text";

        if ($image && $image['tmp_name']) {
            $upload_path = "upload/banner/" . uniqid() . "." . pathinfo($image['name'], PATHINFO_EXTENSION);
            $file_tmp = $image['tmp_name'];

            if (move_uploaded_file($file_tmp, "../" . $upload_path)) {
                $query .= ", image = :image";
            } else {
                return "Unable to upload Image";
            }
        }

        $query .= " WHERE id = :id";
        $stmt = $this->pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":heading", $heading);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":badge_text", $badge_text);
        $stmt->bindParam(":btn_text", $btn_text);

        if (isset($upload_path)) {
            $stmt->bindParam(":image", $upload_path);
        }

        return $stmt->execute() ? "Banner updated successfully" : "Unable to update Banner";
    }


    public function delete_banner_id($id)
    {
        $query = "DELETE FROM banner WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute() ? "" : "";
    }

    public function get_all_banner() 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM banner");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function dashboard_details() 
    {
        $stocksStmt = $this->pdo->prepare("SELECT SUM(quantity) as total FROM inventory");
        $stocksStmt->execute();
        $stocks = $stocksStmt->fetch(PDO::FETCH_ASSOC) ?? 0;
        $stocks = $stocks['total'];

        $orderStmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM orders");
        $orderStmt->execute();
        $order = $orderStmt->fetch(PDO::FETCH_ASSOC) ?? 0;
        $order = $order['total'];

        $saleStmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM orders WHERE status = 'completed' ");
        $saleStmt->execute();
        $sale = $saleStmt->fetch(PDO::FETCH_ASSOC) ?? 0;
        $sale = $sale['total'];

        return [
            'stocks' => $stocks,
            'orders' => $order,
            'sale' => $sale
        ];

    }

}

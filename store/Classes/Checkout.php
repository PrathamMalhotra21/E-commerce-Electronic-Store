<?php

require_once "Database.php";

class Checkout
{
    public $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->con;
    }

    public function save_order($user_id, $total_price, $payment_method, $status, $payment_status, $address)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, total_amount, payment_method, status, payment_status, address) VALUES (:user_id, :total_price, :payment_method, :status, :payment_status, :address)");
        $stmt->bindParam(":user_id",$user_id);
        $stmt->bindParam(":total_price", $total_price);
        $stmt->bindParam(":payment_method", $payment_method);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(":address", $address);
        $stmt->execute();
        $order_id = $this->pdo->lastInsertId();
        return $order_id;
    }

    public function save_order_list($order_id, $product_id, $qty, $price) 
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders_list (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :qty, :price)");
        $stmt->bindParam(":order_id", $order_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":qty", $qty);
        $stmt->bindParam(":price", $price);
        $stmt->execute();

        // Update Qty in inventory
        $stmt = $this->pdo->prepare("SELECT * FROM inventory WHERE product_id = :product_id");
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

        $new_qty = (int) $inventory['quantity'] - (int) $qty;

        $stmt = $this->pdo->prepare("UPDATE inventory SET quantity = :qty WHERE inventory.product_id = :product_id;");
        $stmt->bindParam(":qty", $new_qty);
        $stmt->bindParam(":product_id", $product_id);
        return $stmt->execute();
    }

    public function updateOrder($order_id, $payment_status) 
    {
        $stmt = $this->pdo->prepare("UPDATE orders SET payment_status = :payment_status WHERE id = :order_id");
        $stmt->bindParam(":payment_status", $payment_status);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
    }

}

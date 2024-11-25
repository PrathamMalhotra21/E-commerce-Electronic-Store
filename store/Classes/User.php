<?php

require_once "Database.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


class User
{
    public $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->con;
    }

    public function loginAdmin($username, $password)
    {
        $query = "SELECT username, password FROM admin WHERE username = :user";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":user", $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($password, $result['password'])) {
            return "Login info is incorrect!";
        }

        $_SESSION["user"] = $result['username'];

        return "success";
    }

    public function fetchAdmin($username)
    {
        $query = "SELECT * FROM admin WHERE username = :user";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":user", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAdmin($firstname, $lastname, $username, $password = null)
    {
        if (!empty($password)) {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE admin SET first_name = :first_name, last_name = :last_name, username = :username, password = :password WHERE username = :username";
        } else {
            $query = "UPDATE admin SET first_name = :first_name, last_name = :last_name, username = :username WHERE username = :username";
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":first_name", $firstname);
        $stmt->bindParam(":last_name", $lastname);
        $stmt->bindParam(":username", $username);

        if (!empty($password)) {
            $stmt->bindParam(":password", $pass_hash);
        }

        return $stmt->execute() ? "Profile updated successfully" : "Profile unable to update";
    }

    public function registerCLient($first_name, $last_name, $email, $phone_number, $address, $password)
    {
        // Check if user exists or not
        $checkUser = $this->pdo->prepare("SELECT * FROM clients WHERE email = :email && phone_number = :phone_number");
        $checkUser->bindParam(":email", $email);
        $checkUser->bindParam(":phone_number", $phone_number);
        $checkUser->execute();
        $is_exists = $checkUser->fetch(PDO::FETCH_ASSOC);

        if ($is_exists) {
            return "User is already exists";
        }

        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO clients (first_name, last_name, email, phone_number, address, password) VALUES (:first_name, :last_name, :email, :phone_number, :address, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone_number", $phone_number);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":password", $pass_hash);
        $stmt->execute();

        $lastId = $this->pdo->lastInsertId();
        $query = "SELECT * FROM clients WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $lastId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user_name'] =  $user['first_name'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_address'] =  $user['address'];

        return "success";
    }

    public function loginClient($email, $password)
    {
        $query = "SELECT * FROM clients WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($password, $user['password'])) {
            return "Login info is incorrect!";
        }

        $_SESSION['user_name'] =  $user['first_name'];
        $_SESSION['user_address'] =  $user['address'];
        $_SESSION['user_id'] = $user['id'];

        return "success";
    }

    public function fetchClient($id)
    {
        $query = "SELECT * FROM clients WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateClient($id, $first_name, $last_name, $email, $phone_number, $address, $password = null)
    {
        // Prepare the base query for updating client information
        $query = "UPDATE clients SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, address = :address";

        // Check if a new password is provided, and update it if necessary
        if ($password) {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        // Prepare and bind the parameters
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone_number", $phone_number);
        $stmt->bindParam(":address", $address);

        if ($password) {
            $stmt->bindParam(":password", $pass_hash);
        }

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        // Execute the update query
        $stmt->execute();

        // Fetch the updated client information
        $query = "SELECT * FROM clients WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Update session variables if necessary
        $_SESSION['user_name'] = $user['first_name'];
        $_SESSION['user_id'] = $user['id'];

        return "success";
    }


    public function all_orders($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("SELECT orders.id, clients.first_name, orders.total_amount, orders.payment_method, orders.status, orders.created_at
                                     FROM orders LEFT JOIN clients ON clients.id = orders.user_id ORDER BY orders.id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Total 
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM orders LEFT JOIN clients ON clients.id = orders.user_id");
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC);

        return ['data' => $results, 'total' => $total['count']];
    }

    public function client_order($order_id) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM orders_list LEFT JOIN products ON products.id = orders_list.product_id WHERE orders_list.order_id = :order_id
        ");
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($status, $order_id) {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = :status WHERE id = :id");
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $order_id);
        return $stmt->execute();
    }

    public function all_client_orders($user_id, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("SELECT *
                                     FROM orders WHERE orders.user_id = :user_id ORDER BY orders.id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Total 
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM orders WHERE orders.user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC);

        return ['data' => $results, 'total' => $total['count']];
    }

    public function get_user_order($order_id) 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->bindParam(":id", $order_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

<?php

class Database {
    private $host = "localhost";
    private $username = "root"; 
    private $password = "";
    private $dbname = "store_db";

    public $con;

    public function __construct() {
        try {
            $this->con = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}

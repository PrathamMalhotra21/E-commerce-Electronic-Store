<?php

require_once "../Classes/User.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Post Method is required";
    exit();
}

// admin Login
if (isset($_POST["adminLogin"])) {
    $user = new User();
    $result = $user->loginAdmin($_POST["username"], $_POST["password"]);
    echo $result;
}

// Fetch Admin
if (isset($_POST["fetchAdmin"])) {
    $user = new User();
    $result = $user->fetchAdmin($_SESSION["user"]);
    echo json_encode($result);
}

// Update admin 
if (isset($_POST["updateAdmin"])) {
    $user = new User();
    $result = $user->updateAdmin($_POST["firstName"], $_POST["lastName"], $_POST["username"], $_POST["password"]);
    echo $result;
}

// Register Client
if (isset($_POST["register"])) {
    $user = new User();
    $result = $user->registerCLient($_POST["first-name"], $_POST["last-name"] ,$_POST["email"], $_POST["phone"], $_POST["address"], $_POST["password"]);
    echo $result;
    exit();
}

// Login Clients
if (isset($_POST["loginClient"])) {
    $user = new User();
    $result = $user->loginClient($_POST["email"], $_POST["password"]);
    echo $result;
    exit();
}

// Fetch Client
if (isset($_POST["client_id"])) {
    $user = new User();
    $result = $user->fetchClient($_POST["client_id"]);
    echo json_encode($result);
}

// Update client 
if (isset($_POST["updateClient"])) {
    $user = new User();
    $result = $user->updateClient($_POST["updateClient"], $_POST["firstName"], $_POST["lastName"],  $_POST["email"], $_POST["phone"], $_POST["address"], $_POST["password"]);
    echo $result;
}
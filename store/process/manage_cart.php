<?php

require_once "../Classes/Product.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Post method is required";
    header("Location: ../index.php");
    exit();
}

// Check if cart is exist or not
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Add product to the cart
if (isset($_POST["addCart"])) {
    $id = (int) $_POST["addCart"];

    $product = new Product();
    $result = $product->get_product($id);
    // Product img
    $upload_path = "../upload/Product_" . $id;
    $files = scandir($upload_path);
    $filter_file = array_filter($files, function ($file) {
        return $file !== '.' && $file !== '..';
    });
    $images = array_values($filter_file);
    $product_img = isset($images[0]) ? "./upload/Product_" . $id . "/" . $images[0] : null;
    $product_name = $result['product']['name'];
    $product_price = $result['inventory']['price'];
    $product_qty = 1;


    // Now check if product is in the cart or not
    // If product is there then add 
    // if not remove

    $product_exist = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === (int) $id) {
            $item['qty'] += 1;
            $product_exist = true;
            break;
        }
    }

    if (!$product_exist) {
        $_SESSION['cart'][] = [
            'id' => $id,
            'name' => $product_name,
            'qty' => $product_qty,
            'price' => $product_price,
            'img' => $product_img
        ];
    }

    $_SESSION['cart_quantity'] = count($_SESSION['cart']);
    echo count($_SESSION['cart']);
    exit();
}

// Dec product to the cart
if (isset($_POST["decProduct"])) {
    $id = (int) $_POST["decProduct"];

    // Dec product
    $qty;
    foreach ($_SESSION['cart'] as $key => &$item) {
        if ($item['id'] === (int) $id) {
            if ($item['qty'] < 1) {
                $qty = 0;
                unset($_SESSION['cart'][$key]);
                break;
            }
            $item['qty'] -= 1;
            $qty = $item['qty'];
            break;
        }
    }

    $_SESSION['cart_quantity'] = count($_SESSION['cart']);
    echo $qty;
    exit();
}

// Delete the product from cart
if (isset($_POST["deleteProduct"])) {
    $id = (int) $_POST["deleteProduct"];

    // Delete product
    foreach ($_SESSION['cart'] as $key => &$item) {
        if ($item['id'] === (int) $id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    $_SESSION['cart_quantity'] = count($_SESSION['cart']);
    echo count($_SESSION['cart']);
    exit();
}

if (isset($_POST["emptyCart"])) {
    unset($_SESSION['cart']);
    echo "success";
    exit();
}

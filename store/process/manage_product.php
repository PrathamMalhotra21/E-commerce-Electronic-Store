<?php
require_once "../Classes/Product.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Post method is required";
    exit();
}

// Get all ids category, brand, subcategory
if (isset($_POST["get_all_ids"])) {
    $product = new Product();
    $results = $product->get_all_ids();

    // Build category options
    $categoryText = "<option value=''>Choose Category</option>";
    foreach ($results['category'] as $result) {
        $categoryText .= "<option value='{$result['id']}'>{$result['category_name']}</option>";
    }

    // Build brand options
    $brandText = "<option value=''>Choose Brand</option>";
    foreach ($results['brand'] as $result) {
        $brandText .= "<option value='{$result['id']}'>{$result['brand_name']}</option>";
    }

    // Return JSON response
    echo json_encode([
        'category' => $categoryText,
        'brand' => $brandText
    ]);
    exit();
}

if (isset($_POST['get_all_sub_category'])) {
    $product = new Product();
    $results = $product->get_all_sub_category($_POST["get_all_sub_category"]);
    $subCategoryText = "<option value=''>Choose Sub Category</option>";

    if ($results) {
        foreach ($results as $result) {
            $subCategoryText .= "<option value='{$result['id']}'>{$result['sub_category_name']}</option>";
        }
        echo $subCategoryText;
        exit();
    }

    echo $subCategoryText;
}


// Save
if (isset($_POST["saveProduct"])) {
    $sub_category_id = !empty($_POST['productSubCategory']) ? $_POST['productSubCategory'] : NULL;
    $product = new Product();
    $is_saved = $product->save_product($_POST["productName"], $_POST["specs"], $_POST["productBrand"], $_POST["productCategory"], $sub_category_id, $_POST["status"], $_FILES["productImg"]);
    echo $is_saved ? "roduct added successfully" : "Unable to add product";
}

// Get Product
if (isset($_POST["get_all_product"])) {
    $page = isset($_POST["page"]) ? $_POST['page'] : 1;
    $limit = isset($_POST["limit"]) ? $_POST['limit'] : 10;

    $product = new Product();
    $results = $product->get_all_product($page, $limit);
    echo json_encode([
        'data' => $results['result'],
        'total' => $results['total']
    ]);
}

// Delete Img 
if (isset($_POST["delete_img"])) {
    if (file_exists($_POST["delete_img"])) {
        echo unlink($_POST["delete_img"]) ? "Success" : "Failed";
    } else {
        echo "File not found";
    }
}

// Update
if (isset($_POST["updateProduct"])) {
    $product = new Product();
    $sub_category_id = !empty($_POST['productSubCategory']) ? $_POST['productSubCategory'] : NULL;
    $result = $product->update_product($_POST["id"], $_POST["productName"], $_POST["specs"], $_POST["productBrand"], $_POST["productCategory"], $sub_category_id, $_POST["status"], $_FILES["productImg"]);
    echo $result;
}

// Delete Product
if (isset($_POST["deletePrdouct"])) {
    $product = new Product();
    $result = $product->delete_product($_POST["deletePrdouct"]);
    echo $result;
}

// Search 
if (isset($_POST["search_query"])) {
    $page = isset($_POST["page"]) ? $_POST['page'] : 1;
    $limit = isset($_POST["limit"]) ? $_POST['limit'] : 10;

    $product = new Product();
    $results = $product->search_result($_POST["search_query"], $page, $limit);

    echo json_encode([
        'data' => $results['result'],
        'total' => $results['total']
    ]);
    exit();
}

// Front Search page
if (isset($_POST["search_query_page"])) {
    $product = new Product();
    $results = $product->search_product($_POST["search_query_page"]);
    $img_arr = [];
    foreach ($results as $value) {
        $files = scandir("../upload/Product_" . $value['id']);
        $file_filter = array_filter($files, function($file) {
            return $file != "." && $file != "..";
        });
        $images = array_values($file_filter);
        $firstImage = isset($images[0]) ? $images[0] : null;
        array_push($img_arr, $firstImage);
    }
    echo json_encode([
        'data' => $results,
        'images' => $img_arr
    ]);
    exit();
}
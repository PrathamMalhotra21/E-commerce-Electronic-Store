<?php
require_once "../Classes/Brand.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Post method is required";
    exit();
}

// Save Brand
if (isset($_POST["saveBrand"])) {
    $brand = new Brand();
    $is_saved = $brand->save_brand($_POST["brand_name"], $_POST["description"], $_POST["status"]);
    echo $is_saved ? "Brand added successfully!" : "Unable to save";
    exit();
}

// Get Brand
if (isset($_POST["getBrand"])) {
    $brand = new Brand();

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;

    $results = $brand->get_brand($page, $limit);
    $text = "";
    $i = 1;

    foreach($results['data'] as $result) {
        $status_clr = $result['status'] == "active" ? "success" : "warning";
        $text .= "
            <tr>
                <td>{$i}</td>
                <td>{$result['created_at']}</td>
                <td>{$result['brand_name']}</td>
                <td>{$result['description']}</td>
                <td><p class='text-bg-{$status_clr} rounded-2 text-center'>{$result['status']}</p></td>
                <td>
                    <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                        Action
                    </button>
                        <div class='dropdown-menu py-0' role='menu'>
                        <button class='dropdown-item p-2 editBtn' id='editBtn' data-id='{$result['id']}'><i class='bi bi-pen'></i> Edit</button>
                        <button href='#' class='dropdown-item p-2 deleteBtn' id='deleteBtn' data-id='{$result['id']}'><i class='bi bi-trash3'></i> Delete</button>
                    </div>
                </td>
            </tr>
        ";
        $i++;
    }

    echo json_encode(['html' => $text, 'total' => $results['total'], 'page' => $page, 'limit' => $limit]);
    exit;
}

// Edit Brand
if (isset($_POST["editbrand"])) {
    $brand = new Brand();
    $result = $brand->get_brand_by_id($_POST["editbrand"]);
    echo json_encode($result);
    exit();
}

// Update Brand
if (isset($_POST["updateBrand"])) {
    $categories = new Brand();
    $result = $categories->update_brand($_POST["id"] ,$_POST["brand_name"], $_POST["description"], $_POST["status"]);

    if ($result) {
        echo "Brand updated successfully!";
        exit();
    } else {
        echo "Unable to updated Brand!";
        exit();
    }
}

// Delete Brand
if (isset($_POST["deleteBrand"])) {
    $brand = new Brand();
    $is_deleted = $brand->delete_brand($_POST["id"]);
    if ($is_deleted) {
        echo "Brand deleted successfully";
        exit();
    } else {
        echo "Unable to delete Brand";
        exit();
    }
}

// Search Brand
if (isset($_POST["search_query"])) {
    $categories = new Brand();
    $results = $categories->search_result($_POST["query"]);

    $msg = "";
    $i = 1;

    foreach($results as $result) {
        $status_clr = $result['status'] == "active" ? "success" : "warning";
        $msg .= "
        <tr>
                <td>{$i}</td>
                <td>{$result['created_at']}</td>
                <td>{$result['brand_name']}</td>
                <td>{$result['description']}</td>
                <td><p class='text-bg-{$status_clr} rounded-2 text-center'>{$result['status']}</p></td>
                <td>
                    <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                        Action
                    </button>
                        <div class='dropdown-menu py-0' role='menu'>
                        <button class='dropdown-item p-2 editBtn' id='editBtn' data-id='{$result['id']}'><i class='bi bi-pen'></i> Edit</button>
                        <button href='#' class='dropdown-item p-2 deleteBtn' id='deleteBtn' data-id='{$result['id']}'><i class='bi bi-trash3'></i> Delete</button>
                    </div>
                </td>
            </tr>
        ";
        $i++;
    }

    echo $msg;
}

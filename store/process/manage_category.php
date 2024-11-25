<?php
require_once "../Classes/Category.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Method Should be post";
    header("Location: ../");
    exit();
}

// Save Categories
if (isset($_POST["save_category"])) {
    $categories = new Category();
    $is_success = $categories->save_category($_POST["name"], $_POST["description"], $_FILES["img"], $_POST["status"]);
    echo $is_success;
    exit();
}

// Get Categories 
if (isset($_POST["get_categories"])) {
    $categories = new Category();
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;

    $results = $categories->get_categories($page, $limit);
    $msg = "";
    $i = 1;

    foreach($results['data'] as $result) {
        $status_clr = $result['status'] == "active" ? "success" : "warning";
        $msg .= "
        <tr>
            <td>{$i}</td>
            <td>{$result['category_name']}</td>
            <td>{$result['description']}</td>
            <td><img src='../{$result['image']}' alt='' style='width:100px; height:100px;'></td>
            <td><p class='text-bg-{$status_clr} rounded-2 text-center'>{$result['status']}</p></td>
            <td>
                <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                    Action
                </button>
                <div class='dropdown-menu py-0' role='menu'>
                    <button type='button' class='dropdown-item p-2 editBtn' id='editBtn' data-id='{$result['id']}'><i class='bi bi-pen'></i> Edit</button>
                    <button type='button' href='#' class='dropdown-item p-2 deleteBtn' id='deleteBtn' data-id='{$result['id']}'><i class='bi bi-trash3'></i> Delete</button>
                </div>
            </td>
        </tr>
        ";
        $i++;
    }

    echo json_encode(['html' => $msg, 'total' => $results['total'], 'page' => $page, 'limit' => $limit]);
    exit;
}


// Edit Category
if (isset($_POST["editCategory"])) {
    $categories = new Category();
    $result = $categories->get_category_by_id($_POST["editCategory"]);

    echo json_encode($result);
}

// Update Category
if (isset($_POST["update_category"])) {
    $categories = new Category();
    $result = $categories->update_categroy($_POST["id"] ,$_POST["name"], $_POST["description"], $_FILES["img"], $_POST["status"]);

    if ($result) {
        echo "Category updated successfully!";
        exit();
    } else {
        echo "Unable to updated category!";
        exit();
    }
}

// Delete Category
if (isset($_POST["deleteCategory"])) {
    $categories = new Category();
    $is_deleted = $categories->delete_category($_POST["id"]);
    if ($is_deleted) {
        echo "Category deleted successfully";
        exit();
    } else {
        echo "Unable to delete category";
        exit();
    }
}

// Search Category
if (isset($_POST["search_query"])) {
    $categories = new Category();
    $results = $categories->search_result($_POST["query"]);

    $msg = "";
    $i = 1;

    foreach($results as $result) {
        $status_clr = $result['status'] == "active" ? "success" : "warning";
        $msg .= "
        <tr>
            <td>{$i}</td>
            <td>{$result['category_name']}</td>
            <td>{$result['description']}</td>
            <td><img src='../{$result['image']}' alt='' style='width:100px; height:100px;'></td>
            <td><p class='text-bg-{$status_clr} rounded-2 text-center'>{$result['status']}</p></td>
            <td>
                <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                    Action
                </button>
                <div class='dropdown-menu py-0' role='menu'>
                    <button type='button' class='dropdown-item p-2 editBtn' id='editBtn' data-id='{$result['id']}'><i class='bi bi-pen'></i> Edit</button>
                    <button type='button' href='#' class='dropdown-item p-2 deleteBtn' id='deleteBtn' data-id='{$result['id']}'><i class='bi bi-trash3'></i> Delete</button>
                </div>
            </td>
        </tr>
        ";
        $i++;
    }

    echo $msg;
}

// Get All Categories front
if (isset($_POST["get_all_categroy"])) {
    $text = "";
    $categories = new Category();
    $results = $categories->get_all_category($_POST["get_all_categroy"]);

    foreach($results as $result) {
        $text .= "
            <div class='col col-sm-1 col-md-1 col-lg-3'>
                <div class='text-center'>
                    <a href='./products.php?id={$result['id']}' class='text-dark text-decoration-none'>
                        <img src='./{$result['image']}' alt='' class='rounded-circle' style='width:100px; height:100px'>
                        <div class='my-2'>
                            <h6>{$result['category_name']}</h6>
                        </div>
                    </a>
                </div>
            </div>
        ";
    }

    echo $text;
}
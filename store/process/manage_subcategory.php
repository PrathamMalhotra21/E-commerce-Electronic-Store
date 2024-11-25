<?php

require_once "../Classes/SubCategory.php";
require_once "../Classes/Category.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Post method required";
    exit();
}

// Get Category
if (isset($_POST["get_all_category"])) {
    $categories = new Category();
    $results = $categories->get_all_category();
    $text = "<option value=''>Choose a category</option>";

    foreach($results as $result) {
        $text .= "<option value='{$result['id']}'>{$result['category_name']}</option>";
    }

    echo $text;
}

// Save Category
if (isset($_POST["Save_subCategory"])) {
    $sub_categories = new SubCategory();
    $is_success = $sub_categories->save_subcategory($_POST["category"], $_POST["name"], $_POST["description"], $_POST["status"]);
    echo $is_success ? "Sub Category added successfully" : "Unable to add Sub Category";
    exit();
}

// Get Sub Category
if (isset($_POST["get_sub_category"])) {
    $sub_categories = new SubCategory();

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
    $results = $sub_categories->get_sub_categories($page, $limit);

    $text = "";
    $i = 1;

    foreach ($results['data'] as $result) {
        $status_clr = $result["status"] == "active" ? "success" : "warning";
        $text .= "
            <tr>
                <td>{$i}</td>
                <td>{$result['category_name']}</td>
                <td>{$result['sub_category_name']}</td>
                <td>{$result['description']}</td>
                <td><p class='text-bg-{$status_clr} rounded-2 text-center'>{$result['status']}</p></td>
                <td>
                    <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                        Action
                    </button>
                    <div class='dropdown-menu py-0' role='menu'>
                        <button id='editBtn' class='dropdown-item p-2 editBtn' data-id='{$result['id']}'><i class='bi bi-pen'></i> Edit</button>
                        <button id='deleteBtn' class='dropdown-item p-2 deleteBtn' data-id='{$result['id']}'><i class='bi bi-trash3'></i> Delete</button>
                    </div>
                </td>
            </tr>
        ";
        $i++;
    };

    echo json_encode(['html' => $text, 'total' => $results['total'], 'page' => $page, 'limit' => $limit]);
    exit();

}

// Edit Sub Category
if (isset($_POST["editSubCategory"])) {
    $sub_categories = new SubCategory();
    $result = $sub_categories->get_subcategory_by_id($_POST["editSubCategory"]);

    echo json_encode($result);
}

// Update Sub Category
if (isset($_POST["Update_subCategory"])) {
    $sub_categories = new SubCategory();
    $result = $sub_categories->update_subcategroy($_POST["id"], $_POST["category"], $_POST["name"], $_POST["description"], $_POST["status"]);

    if ($result) {
        echo "Category updated successfully!";
        exit();
    } else {
        echo "Unable to updated Sub category!";
        exit();
    }
}

// Delete Sub Category
if (isset($_POST["deleteSubCategory"])) {
    $sub_categories = new SubCategory();
    $is_deleted = $sub_categories->delete_subcategory($_POST["id"]);
    if ($is_deleted) {
        echo "Category deleted successfully";
        exit();
    } else {
        echo "Unable to delete category";
        exit();
    }
}

// Search 
if (isset($_POST["search_query"])) {
    $sub_categories = new SubCategory();

    $results = $sub_categories->search_result($_POST["query"]);

    $text = "";
    $i = 1;

    foreach ($results as $result) {
        $status_clr = $result["status"] == "active" ? "success" : "warning";
        $text .= "
            <tr>
                <td>{$i}</td>
                <td>{$result['category_name']}</td>
                <td>{$result['sub_category_name']}</td>
                <td>{$result['description']}</td>
                <td><p class='text-bg-{$status_clr} rounded-2 text-center'>{$result['status']}</p></td>
                <td>
                    <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                        Action
                    </button>
                    <div class='dropdown-menu py-0' role='menu'>
                        <button id='editBtn' class='dropdown-item p-2 editBtn' data-id='{$result['id']}'><i class='bi bi-pen'></i> Edit</button>
                        <button id='deleteBtn' class='dropdown-item p-2 deleteBtn' data-id='{$result['id']}'><i class='bi bi-trash3'></i> Delete</button>
                    </div>
                </td>
            </tr>
        ";
        $i++;
    };

    echo $text;
    exit();

}
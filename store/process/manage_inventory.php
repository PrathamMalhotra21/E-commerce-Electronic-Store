<?php

require_once "../Classes/Inventory.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Post method required";
    exit();
}

// Get product id
if (isset($_POST["get_product_id"])) {
    $inventory = new Inventory();
    $results = $inventory->get_product_id();
    $text = "<option value=''>Choose a product</option>";

    foreach ($results as $value) {
        $text .= "<option value='{$value['id']}'>{$value['name']}</option>";
    }

    echo $text;
   
}

// Save
if (isset($_POST["saveInventory"])) {
    $inventory = new Inventory();
    $is_saved = $inventory->save_inventory($_POST["product_id"], $_POST["quantity"], $_POST["amount"]);
    echo $is_saved;
}

// Update
if (isset($_POST["updateInventory"])) {
    $inventory = new Inventory();
    $is_updated = $inventory->update_inventory($_POST['id'], $_POST["product_id"], $_POST["quantity"], $_POST["amount"]);
    echo $is_updated;
}

// Get table
if (isset($_POST["get_inventory"])) {
    $page = isset($_POST["page"]) ? $_POST["page"] : 1;
    $limit = isset($_POST["limit"]) ? $_POST["limit"] : 10;

    $inventory = new Inventory();
    $result = $inventory->get_inventory($page, $limit);
    $text = "";
    $i = 1;

    foreach ($result['data'] as $value) {
        $text .= "
            <tr>
                <td>{$i}</td>
                <td>{$value['date_created']}</td>
                <td>{$value['name']}</td>
                <td>{$value['price']}</td> <!-- Fixed 'amount' field -->
                <td>{$value['quantity']}</td>
                <td>
                    <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                        Action
                    </button>
                    <div class='dropdown-menu py-0' role='menu'>
                        <button data-id='{$value['id']}' id='editBtn' class='dropdown-item p-2 editBtn'><i class='bi bi-pen'></i> Edit</button>
                        <button data-id='{$value['id']}' id='deleteBtn' class='dropdown-item p-2 deleteBtn'><i class='bi bi-trash3'></i> Delete</button>
                    </div>
                </td>
            </tr>
        ";
        $i++;
    }

    echo json_encode([
        'html' => $text,
        'total' => $result['total'],
        'page' => $page
    ]);
    exit();
}

// Edit
if (isset($_POST["editInventory"])) {
    $inventory = new Inventory();
    $result = $inventory->get_inventory_id($_POST["editInventory"]);
    echo json_encode($result);
    exit();
}

// Delete Inventory
if (isset($_POST["deleteInventory"])) {
    $inventory = new Inventory();
    $result = $inventory->delete_inventory($_POST["deleteInventory"]);
    echo $result;
}

// Search
if (isset($_POST["search_query"])) {
    // Receive page and limit from AJAX request
    $page = isset($_POST["page"]) ? $_POST["page"] : 1;
    $limit = isset($_POST["limit"]) ? $_POST["limit"] : 10;
    $search_query = $_POST["search_query"]; // Get the search query

    $inventory = new Inventory();
    // Pass search query along with pagination params to the search function
    $result = $inventory->search_inventory($page, $limit, $search_query);

    $text = "";
    $i = 1;

    foreach ($result['data'] as $value) {
        $text .= "
            <tr>
                <td>{$i}</td>
                <td>{$value['date_created']}</td>
                <td>{$value['name']}</td>
                <td>{$value['price']}</td> <!-- Corrected the field name from 'amount' -->
                <td>{$value['quantity']}</td>
                <td>
                    <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                        Action
                    </button>
                    <div class='dropdown-menu py-0' role='menu'>
                        <button data-id='{$value['id']}' id='editBtn' class='dropdown-item p-2 editBtn'><i class='bi bi-pen'></i> Edit</button>
                        <button data-id='{$value['id']}' id='deleteBtn' class='dropdown-item p-2 deleteBtn'><i class='bi bi-trash3'></i> Delete</button>
                    </div>
                </td>
            </tr>
        ";
        $i++;
    }

    // Return the HTML, total count, and page number as JSON
    echo json_encode([
        'html' => $text, // Corrected key to 'html'
        'total' => $result['total'],
        'page' => $page
    ]);
    exit();
}

<?php

require_once "../Classes/User.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Post method is required";
    header("Location: ../admin/");
    exit();
}

function get_color($status) {
    switch ($status) {
        case 'pending':
            return 'warning';
        case 'processing':
            return 'dark';
        case 'completed':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return '';
    }
}

if (isset($_POST["loadOrder"])) {
    $limit = isset($_POST["limit"]) ? $_POST["limit"] : 10;
    $page = isset($_POST["page"]) ? $_POST["page"] : 1;

    $orders = new User();
    $results = $orders->all_orders($page, $limit);
    $text = "";
    $i = 0;

    foreach ($results['data'] as $key => $value) {
        $status_clr = get_color($value['status']);
        $pay_clr = $value['payment_method'] == "paypal" ? "primary" : "success";
        $text .= "
            <tr>
                <td>{$i}</td>
                <td>{$value['created_at']}</td>
                        <td>{$value['first_name']}</td>
                        <td>$ {$value['total_amount']}</td>
                        <td>
                            <p class='text-bg-{$pay_clr} rounded-2 text-center'>{$value['payment_method']}</p>
                        </td>
                        <td>
                            <p class='text-bg-{$status_clr} rounded-2 text-center'>{$value['status']}</p>
                        </td>
                        <td>
                            <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                                Action
                            </button>
                            <div class='dropdown-menu py-0' role='menu'>
                                <a href='./view_order.php?order_id={$value['id']}' id='viewOrder' class='dropdown-item p-2 editBtn'><i class='bi bi-pen'></i> Update</a>
                            </div>
                        </td>
                    </tr>
        ";
        $i++;

    }
    echo json_encode([
        "text" => $text,
        'total' => $results['total'],
        'page' => $page
    ]);
}

if (isset($_POST["updateStatus"])) {
    $orders = new User();
    $result = $orders->updateStatus($_POST["status"], $_POST["order_id"]);
    if ($result) {
        header("Location: ../admin/order.php");
        exit();
    } else {
        header("Location: ../view_order.php?order_id={$_POST['order_id']}");
        exit();
    }
}

if (isset($_POST["loadClients"])) {
    $limit = isset($_POST["limit"]) ? $_POST["limit"] : 10;
    $page = isset($_POST["page"]) ? $_POST["page"] : 1;

    $orders = new User();
    $results = $orders->all_client_orders($_POST["loadClients"], $page, $limit);
    $text = "";
    $i = 0;

    foreach ($results['data'] as $key => $value) {
        $status_clr = get_color($value['status']);
        $pay_clr = $value['payment_method'] == "paypal" ? "primary" : "success";
        $text .= "
            <tr>
                <td>{$i}</td>
                <td>{$value['created_at']}</td>
                        <td>{$value['id']}</td>
                        <td>$ {$value['total_amount']}</td>
                        <td>
                            <p class='text-bg-{$status_clr} rounded-2 text-center'>{$value['status']}</p>
                        </td>
                        <td>
                            <input type='hidden' name='address' value='{$value['address']}' id='address_{$value['id']}'>
                            <input type='hidden' name='status' value='{$value['status']}' id='status_{$value['id']}'>
                            <button data-bs-target='#orderModal' data-bs-toggle='modal' id='order_id' data-id='{$value['id']}' class='btn btn-outline-dark rounded-0'><i class='bi bi-eye'></i> View</button>
                        </td>
                    </tr>
        ";
        $i++;

    }
    echo json_encode([
        "text" => $text,
        'total' => $results['total'],
        'page' => $page
    ]);
}

// Get the user order
if (isset($_POST["get_order"])) {
    $orders = new User();
    $results = $orders->client_order($_POST["get_order"]);
    echo json_encode($results);
}
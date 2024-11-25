<?php

require_once "../Classes/System.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Post method is required";
    exit();
}

// save
if (isset($_POST["save_banner"])) {
    $banner = new System();
    $result = $banner->save_banner($_POST["heading"], $_POST["title"], $_POST["badge"], $_POST["btnText"], $_FILES["bannerImg"]);
    echo $result;
}

// Get Banner
if (isset($_POST["load_banner"])) {
    $banner = new System();
    $results = $banner->get_banner();
    $text = "";
    $i = 1;
    foreach ($results as $value) {
        $text .= "
        <tr>
            <td>{$i}</td>
            <td>{$value['heading']}</td>
            <td>{$value['title']}</td>
            <td>{$value['badge_text']}</td>
            <td>{$value['btn_text']}</td>
            <td>
                <img src='../{$value['image']}' alt='Placeholder' class='img-fluid'>
            </td>
            <td>
                <div class='dropdown-start'>
                    <button type='button' data-bs-toggle='dropdown' class='btn btn-outline-dark btn-default btn-sm dropdown-toggle'>
                        Action
                    </button>
                    <div class='dropdown-menu py-0' role='menu'>
                        <button id='editBtn' data-id='{$value['id']}' class='dropdown-item p-2 editBtn'><i class='bi bi-pen'></i> Edit</button>
                        <button id='deleteBtn' data-id='{$value['id']}' class='dropdown-item p-2 deleteBtn'><i class='bi bi-trash3'></i> Delete</button>
                    </div>
                </div>
            </td>
        </tr>
        ";
        $i++;
    }
    echo $text;
}

// Edit
if (isset($_POST["edit_banner"])) {
    $banner = new System();
    $result = $banner->get_banner_id($_POST["edit_banner"]);
    echo json_encode($result);
}

// Update
if (isset($_POST["update_banner"])) {
    $banner = new System();
    $result = $banner->update_banner($_POST["id"], $_POST["heading"], $_POST["title"], $_POST["badge"], $_POST["btnText"], $_FILES["bannerImg"]);
    echo $result;
}

// Delete 
if (isset($_POST["delete_banner"])) {
    $banner = new System();
    $result = $banner->delete_banner_id($_POST["delete_banner"]);
    echo json_encode($result);
}

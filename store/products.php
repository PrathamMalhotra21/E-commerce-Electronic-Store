<?php
require_once "./includes/header.php";
require_once "./Classes/Product.php";
require_once "./Classes/SubCategory.php";

$products = new Product();
$subCategroy = new SubCategory();

// Get id
$id;
$results;
$upload_img = "./upload/Product_";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sub_id = isset($_GET["sub_id"]) ? $_GET["sub_id"] : null;
    $results = isset($sub_id) ? $products->get_products_by_category($id, "active", $sub_id) : $products->get_products_by_category($id, "active");
}


// Function to get the first image of a product
function get_first_image($product_id) {
    $folder_path = "./upload/Product_" . $product_id . "/";
    $images = glob($folder_path . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
    return $images && count($images) > 0 ? $images[0] : "./path/to/placeholder.jpg";
}

// Get sub Categroy
$sub_categroy = $subCategroy->get_cat_subCategroy($id);
?>

<body>
    <?php require_once "./includes/navigation.php"; ?>

    <section id="product" style="padding-top:50px; padding-bottom:50px;">
        <div class="container">
            <div class="d-flex justify-content-between">
                <h3>Products</h3>
                <button class="btn btn-outline-dark rounded-0" id="filter" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="offcanvasRight">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>
        </div>

        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-3">

            <?php foreach($results as $result): ?>
                <div class="col">
                    <a href="./productView.php?id=<?php echo $result['id'] ?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm hover:shadow-lg transition-shadow">
                            <img src="<?php echo get_first_image($result['id']); ?>" alt="<?php echo htmlspecialchars($result['name']); ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title text-dark"><?php echo htmlspecialchars($result['name']); ?></h5>
                                <p class="card-text text-primary fw-bold">$<?php echo number_format($result['price'], 2); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>

            </div>
        </div>

    </section>

    <!-- Filter OffCanvas -->
    <div class="offcanvas offcanvas-end" id="filterOffcanvas" tabindex="-1" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <h6>Browse by</h6>
            <ul class="list-group">
            <li class='list-group-item border-0 w-100 text-dark'><a href='products.php?id=<?php echo $id ?>' class='text-decoration-none'>All Sub Category</a></li>
                <?php    
                foreach ($sub_categroy as $key => $value) {
                    echo "<li class='list-group-item border-0 w-100 text-dark'><a href='products.php?id={$id}&sub_id={$value['id']}' class='text-decoration-none'>{$value['sub_category_name']}</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <?php require_once "./includes/footer.php"; ?>
</body>

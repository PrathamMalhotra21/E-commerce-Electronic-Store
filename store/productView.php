<?php
require_once "./includes/header.php";
require_once "./Classes/Product.php";

$products = new Product();
if (!isset($_GET['id'])) {
    header("Location: ./index.php");
}

$id = $_GET['id'];
$results = $products->get_product($id);

$data = $results['product'];
$inventory = $results['inventory'];

$dir = "./upload/Product_" . $id;
$files = scandir($dir);
$productImages = array_filter($files, function ($file) {
    return $file !== '.' && $file !== '..';
});

?>

<body>
    <?php require_once "./includes/navigation.php"; ?>

    <section id="productView">
        <div class="container">
            <div class="row p-3">
                <div class="col-md-6">
                    <div id="carouselExampleAutoplaying" class="carousel slide mb-2" data-bs-ride="carousel" style="min-width: 300px; min-height: 300px;">
                        <div class="carousel-inner">

                            <?php $counter = 0; ?>
                            <?php foreach ($productImages as $image): ?>
                                <div class="carousel-item <?php echo ($counter == 0) ? 'active' : ''; ?>">
                                    <img src="<?php echo $dir . "/" . $image ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php $counter++; ?>
                            <?php endforeach; ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="col-md-6">
                    <h2><?php echo $data['name'] ?></h2>
                    <h6 style="font-size:14px; color: grey;">Brand: <?php echo $data['brand_name'] ?></h6>
                    <hr class="hr">
                    <h4 class="text-dark">$<?php echo $inventory['price'] ?></h4>
                    <div class="mb-3 mt-4">
                        <button type="button" id="addToCart" data-id="<?php echo $id ?>" class="btn text-white rounded-0" style="background-color:#2250dd; border:none;">Add To Cart</button>
                        <button type="button" id="buyNow" data-id="<?php echo $id ?>" class="btn text-white rounded-0" style="background-color:#000000a6; border:none;">Buy Now</button>
                    </div>
                </div>
            </div>
            <div class="row px-3 py-3">
                <div class="col">
                    <h4>Description</h4>
                    <div><?php echo $data['specs'] ?></div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "./includes/footer.php" ?>

    <script src="./assets/js/addProduct.js"></script>
</body>
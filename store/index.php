<?php
require_once "./includes/header.php";
require_once "./Classes/Product.php";
$products = new Product();
$results = $products->get_all_product(1, 4, "active");

$data = $results['result'];

?>

<body>
    <?php require_once "./includes/navigation.php"; ?>
    <?php require_once "./includes/carousel.php"; ?>

    <section>
        <div class="container py-5">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                <!-- Curb-side Pickup -->
                <div class="col">
                    <div class="text-center">
                        <div class="mb-3">
                            <span class="bg-primary bg-opacity-10 px-3 py-2 rounded-5 d-inline-block">
                                <i class="bi bi-shop fs-2 text-primary"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold">Curb-side Pickup</h5>
                        <p class="text-muted small">Quick and convenient pickup right from your car</p>
                    </div>
                </div>

                <!-- Free Shipping -->
                <div class="col">
                    <div class="text-center">
                        <div class="mb-3">
                            <span class="bg-success bg-opacity-10 px-3 py-2 rounded-5 d-inline-block">
                                <i class="bi bi-truck fs-2 text-success"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold">Free Shipping</h5>
                        <p class="text-muted small">Free shipping on all orders</p>
                    </div>
                </div>

                <!-- Low Prices -->
                <div class="col">
                    <div class="text-center">
                        <div class="mb-3">
                            <span class="bg-danger bg-opacity-10 px-3 py-2 rounded-5 d-inline-block">
                                <i class="bi bi-tag fs-2 text-danger"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold">Low Prices Guaranteed</h5>
                        <p class="text-muted small">Best prices and value for your money</p>
                    </div>
                </div>

                <!-- 24/7 Availability -->
                <div class="col">
                    <div class="text-center">
                        <div class="mb-3">
                            <span class="bg-warning bg-opacity-10 px-3 py-2 rounded-5 d-inline-block">
                                <i class="bi bi-clock fs-2 text-warning"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold">Available 24/7</h5>
                        <p class="text-muted small">Shop anytime, we're always here for you</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="featuredProduct" style="padding-top:50px; padding-bottom:50px;">
        <div class="container d-flex justify-content-between">
            <h4>Featured Products</h4>
            <a href="./category.php" class="btn btn-outline-dark rounded-0">View All</a>
        </div>

        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-3">

            <?php 
                foreach($data as $result): 
                    $dir =  './upload/Product_' . $result['id'];
                    $files = scandir($dir);
                    $productImages = array_filter($files, function ($file) {
                        return $file !== '.' && $file !== '..';
                    });
                    $images = array_values($productImages);
                    $firstImage = isset($images[0]) ? $images[0] : null;
                
            ?>
                <div class="col">
                    <a href="./productView.php?id=<?php echo $result['id'] ?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm hover:shadow-lg transition-shadow">
                            <img src="./<?php echo $dir . "/" . $firstImage ?>" alt="Wireless Earbuds" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title text-dark"><?php echo $result['name'] ?></h5>
                                <p class="card-text text-primary fw-bold">$<?php echo $result['price'] ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>

            </div>
        </div>

    </section>

    <?php require_once "./includes/footer.php" ?>
</body>
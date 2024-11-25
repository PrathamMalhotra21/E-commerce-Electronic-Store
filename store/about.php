<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navigation.php"; ?>
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <span class="badge mb-3 rounded-1" style="background-color: #333; color: white;">About TechMart</span>
                <h1 class="fw-bold mb-4">Your Trusted Electronics Partner Since 2010</h1>
                <p class="lead text-muted mb-4">We're dedicated to bringing you the latest technology at competitive prices, with exceptional customer service that sets us apart.</p>
                <a href="#contact" class="btn rounded-0" style="background-color: #2250dd; color: white; letter-spacing: 1px;">Contact</a>
            </div>
            <div class="col-lg-6">
                <img src="./upload/headphone.webp" alt="Store Front" class="img-fluid rounded shadow">
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row g-4 mb-5">
            <div class="col-6 col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold text-info mb-2">13+</h2>
                    <p class="text-muted small text-uppercase">Years of Experience</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold text-danger mb-2">50k+</h2>
                    <p class="text-muted small text-uppercase">Happy Customers</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold text-warning mb-2">1000+</h2>
                    <p class="text-muted small text-uppercase">Products</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold text-success mb-2">24/7</h2>
                    <p class="text-muted small text-uppercase">Customer Support</p>
                </div>
            </div>
        </div>

        <!-- Mission & Values -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-bullseye text-info fs-1"></i>
                        </div>
                        <h4 class="card-title mb-3">Our Mission</h4>
                        <p class="card-text text-muted">To provide cutting-edge technology solutions that enhance people's lives while ensuring exceptional customer service and support.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-eye text-danger fs-1"></i>
                        </div>
                        <h4 class="card-title mb-3">Our Vision</h4>
                        <p class="card-text text-muted">To become the most trusted electronics retailer by consistently delivering quality products and outstanding customer experiences.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-star text-warning fs-1"></i>
                        </div>
                        <h4 class="card-title mb-3">Our Values</h4>
                        <p class="card-text text-muted">Integrity, innovation, customer satisfaction, and continuous improvement drive everything we do.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php require_once "./includes/footer.php" ?>
</body>
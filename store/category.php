<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navigation.php"; ?>

    <div class="container py-5">
        <!-- Page Title -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-4">Shop by Category</h2>
                <p class="text-muted">Explore our wide range of electronic products</p>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="row g-4" id="allCategroy">
        </div>

    </div>

    <?php require_once "./includes/footer.php" ?>

    <script src="./assets/js/category.js"></script>
</body>
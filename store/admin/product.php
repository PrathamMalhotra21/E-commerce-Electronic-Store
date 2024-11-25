<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <section class="main-content">
        <div class="mb-3 p-2 bg-white rounded-3">
            <div class="d-flex justify-content-between">
                <h2>Products</h2>
                <a href="./addProduct.php" class="rounded-3 p-2 text-decoration-none bg-opacity-10 bg-primary">
                    <p class="text-primary mb-0 align-item-center align-middle"><i class="bi bi-plus-circle"></i> Add Product</p>
                </a>
            </div>
        </div>

        <div class="mb-3 bg-white p-2 rounded-2">
            <input type="text" name="search" id="search" value="" class="form-control" placeholder="Search here">
        </div>

        <div class="mb-3 p-2 bg-white rounded-3">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:5%">#</th>
                        <th style="width:15%">Name</th>
                        <th style="width:15%">Brand</th>
                        <th style="width:5%">Status</th>
                        <th style="width:15%">Action</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                </tbody>
            </table>
        </div>

        <div class="mb-3">
            <nav class="d-flex justify-content-center" aria-label="Page navigation">
                <ul class="pagination shadow-sm">
                </ul>
            </nav>
        </div>

    </section>

    <script src="./assets/js/product.js"></script>
</body>
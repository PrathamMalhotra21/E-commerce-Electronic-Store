<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <section class="main-content">
        <div class="mb-3 p-2 bg-white rounded-3">
            <div class="d-flex justify-content-between">
                <h2>Order</h2>
                <input type="text" name="search" id="search" class="form-control w-50" placeholder="Search here">
            </div>
        </div>

        

        <div class="mb-3 p-2 bg-white rounded-3">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:5%">#</th>
                        <th style="width:20%">Date Created</th>
                        <th style="width:20%">Clinet</th>
                        <th style="width:20%">Total Amount</th>
                        <th style="width:5%">Payment</th>
                        <th style="width:5%">Status</th>
                        <th style="width:15%">Action</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                    
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

    <script src="./assets/js/orders.js"></script>

</body>
<?php
require_once "./includes/header.php";
require_once "../Classes/System.php";

$sys = new System();
$result = $sys->dashboard_details();

?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <div class="main-content">
        <h2>Dashboard</h2>
        <p>Welcome to the Admin Panel!</p>

        <!-- Add main content here -->

        <div class="content">
            <div class="card">
                <i class="bi bi-boxes card-icon bg-primary text-primary bg-opacity-10"></i>
                <div class="card-body">
                    <h5>Total Stocks</h5>
                    <p><?php echo $result['stocks'] ?></p>
                </div>
            </div>

            <div class="card">
                <i class="bi bi-clipboard2-data card-icon bg-success text-success bg-opacity-10"></i>
                <div class="card-body">
                    <h5>Total Orders</h5>
                    <p><?php echo $result['orders'] ?></p>
                </div>
            </div>

            <div class="card">
                <i class="bi bi-receipt-cutoff card-icon bg-info text-info bg-opacity-10"></i>
                <div class="card-body">
                    <h5>Total Sales</h5>
                    <p><?php echo $result['sale'] ?></p>
                </div>
            </div>
        </div>

    </div>
</body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Brand -->
        <a class="navbar-brand ms-2 me-auto" href="./index.php">
            <i class="fas fa-laptop-code text-primary"></i> TechZone
        </a>

        <!-- User Actions -->
        <div class="d-flex align-items-center order-md-3">

            <div class="dropdown">
                <button class="btn btn-person dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person fs-5"></i> <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "Login" ?>
                </button>
                <ul class="dropdown-menu">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a class="dropdown-item navBtn" href="./login.php"><i class="bi bi-person-circle"></i> Login</a></li>
                    <li><a class="dropdown-item navBtn" href="./register.php"><i class="bi bi-person-circle"></i> Register</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item navBtn" href="./orders.php"><i class="bi bi-box-seam"></i> Orders</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a class="dropdown-item navBtn" href="./profile.php"><i class="bi bi-person-gear fs-5"></i> Profile</a></li>
                    <li><a class="dropdown-item logoutBtn" href="./process/logoutClient.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <a href="./search.php" class="btn btn-link text-dark me-1">
                <i class="bi bi-search icon-size"></i>
            </a>

            <a href="./cart.php" class="text-dark position-relative">
                <i class="bi bi-cart3 icon-size"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" id="cartQty">
                    <?php echo isset($_SESSION['cart_quantity']) ? $_SESSION['cart_quantity'] : 0; ?>
                </span>
            </a>
        </div>

        <!-- Navigation Items -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./category.php">Categories</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="./products.php">Product</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="./about.php">About</a>
                </li>
            </ul>
        </div>

    </div>
</nav>
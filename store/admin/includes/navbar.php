<!-- SideBar -->
<nav class="navbar">
    <div class="container px-4 pb-3">
        <div class="d-flex justify-content-between w-100 position-relative">
            <button class="btn btn-outline-dark rounded-0" id="sidebarBtn" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminNavbar" aria-controls="offcanvasExample">
                <i class="bi bi-justify"></i>
            </button>

            <div class="dropdown position-absolute end-0">
                <button type="button" class="btn rounded-0 btn-outline-dark" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- <img src="../upload/banner1.webp" alt="Profile" style="width: 30px; height: 30px; border:2px solid white;" class="rounded-5"> -->
                    <i class="bi bi-person"></i> <?php echo isset($_SESSION["user"]) ? $_SESSION["user"] : "Admin" ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end mt-2 shadow">
                    <li>
                        <a class="dropdown-item personIcon p-2 px-3 fs-6" href="./profile.php">
                            <i class="bi bi-person"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a href="./logout.php" class="dropdown-item logoutIcon p-2 px-3 fs-6" href="#">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start shadow-sm" tabindex="-1" id="adminNavbar" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasLabel">Admin Panel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="./index.php" class="nav-link active"><i class="bi bi-house-door"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="./product.php" class="nav-link"><i class="bi bi-archive"></i> Product</a>
            </li>
            <li class="nav-item">
                <a href="./inventory.php" class="nav-link"><i class="bi bi-clipboard-data"></i> Inventory</a>
            </li>
            <li class="nav-item">
                <a href="./order.php" class="nav-link"><i class="bi bi-receipt"></i> Order List</a>
            </li>
            <li class="nav-item">
                <a href="./brand.php" class="nav-link"><i class="bi bi-bootstrap"></i> Brand</a>
            </li>
            <li class="nav-item">
                <a href="./category.php" class="nav-link"><i class="bi bi-card-list"></i> Category</a>
            </li>
            <li class="nav-item">
                <a href="./subCategory.php" class="nav-link"><i class="bi bi-card-list"></i> Sub Category</a>
            </li>
            <li class="nav-item">
                <a href="./settings.php" class="nav-link"><i class="bi bi-gear"></i> Settings</a>
            </li>
        </ul>
    </div>
</div>
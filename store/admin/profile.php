<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <section class="main-content">
        <div class="mb-3 p-2 px-3 bg-white rounded-3">
            <div class="d-flex justify-content-between">
                <h2>Profile</h2>
            </div>
        </div>

        <form id="updateProfile">
            <div class="mb-3 p-2 px-3 bg-white rounded-3">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" name="firstName" id="firstName" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" name="lastName" id="lastName" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">User Name</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <span class="text-danger">*Enter passoword when you want to change</span>
                </div>

            </div>

            <div class="mb-3 p-2 px-3 bg-white rounded-3">
                <div class="btn-group w-100">
                    <button type="submit" id="updateProfileBtn" class="btn btn-outline-warning">Update</button>
                    <a href="./index.php" class="btn btn-outline-danger">Discard</a>
                </div>
            </div>
        </form>

    </section>

    <script src="./assets/js/profile.js"></script>
</body>
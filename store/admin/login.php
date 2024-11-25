<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: ./index.php");
    exit();
}
?>

<body>
    <section id="login">
        <div class="container container-center">
            <div class="card card-style">
                <h2 class="pt-3 text-center">Admin - Login</h2>
                <div class="card-body">
                    <form id="adminLogin">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <a href="../index.php">Go Back to Website</a>
                            <button type="submit" name="login" class="btn btn-login w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="./assets/js/login.js"></script>
</body>

</html>
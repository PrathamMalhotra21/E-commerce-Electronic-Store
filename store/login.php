<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navigation.php"; ?>

    <section>
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="card p-5 shadow" style="width: 400px;">
                <h2 class="mb-4 text-center">Login</h2>
                <form id="loginClient">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <a href="./register.php" class="">Don't have account ?</a>
                    <div class="d-grid">
                        <button type="submit" class="btn text-white rounded-0 mt-3" style="background-color: #2250dd;">Login</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <?php require_once "./includes/footer.php" ?>

    <script>
        $(document).ready(function() {
            $("#loginClient").on("submit", function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append("loginClient", true);

                $.ajax({
                    url: "./process/manage_user.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == "success") {
                            window.location.href = "./index.php";
                        } else {
                            alert(response)
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>
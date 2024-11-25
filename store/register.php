<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navigation.php"; ?>

    <section id="register" style="padding-top: 100px; padding-bottom: 100px;">
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="card p-5 shadow" style="width: 400px;">
                <h2 class="mb-4 text-center">Register</h2>
                <form id="clientRegister">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first-name" class="form-label">First Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first-name" id="first-name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last-name" class="form-label">Last Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last-name" id="last-name" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number<span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="phone" id="phone" maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                        <textarea name="address" id="address" name="address" required class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <a href="./login.php" class="">Already have account ?</a>
                    <div class="d-grid mt-2">
                        <button type="submit" name="register" class="btn text-white rounded-0" style="background-color: #2250dd;">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php require_once "./includes/footer.php" ?>
    <script>
        $("#clientRegister").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("register", true);
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            $.ajax({
                url: "./process/manage_user.php",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response == "success") {
                        window.location.href = "./index.php";
                    } else {
                        alert(response);
                    }
            
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });

        });
    </script>
</body>
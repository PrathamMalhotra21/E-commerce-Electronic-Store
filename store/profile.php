<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navigation.php"; ?>

    <section id="updateProfile">
        <div class="container p-3">
            <div class="card">
                <div class="card-header">
                    <h3>Account Details Update</h3>
                    <p style="font-size: 12px;" class="text-danger p-0">*Update account detail</p>
                </div>

                <form id="updateClient">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" name="firstName" name="firstName" id="firstName" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" name="lastName" name="lastName" id="lastName" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" name="phone" name="phone" id="phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" name="address" class="form-control" aria-required=""></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" name="password" id="password" class="form-control">
                            <span class="text-danger">*Enter password if you want to change.</span>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="btn-group w-100">
                            <button type="submit" id="updateProfileBtn" class="btn btn-outline-warning">Update</button>
                            <a href="./index.php" class="btn btn-outline-danger">Discard</a>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </section>

    <?php require_once "./includes/footer.php" ?>
    <script>
        id = Number("<?php echo $_SESSION["user_id"] ?>");
     
        function loadClient(id) {
            $.ajax({
                url: "./process/manage_user.php",
                data: {client_id: id},
                method: "POST",
                success: function(response) {
                    const data = JSON.parse(response);
                    console.log(data);
                    $("#firstName").val(data.first_name);
                    $("#lastName").val(data.last_name);
                    $("#email").val(data.email);
                    $("#phone").val(data.phone_number);
                    $("#address").val(data.address);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        };
        loadClient(id);

        $("#updateClient").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append("updateClient", id);

            $.ajax({
                url: "./process/manage_user.php",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == "success") {
                        alert("Profile is updated!");
                        loadClient(data.id);
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
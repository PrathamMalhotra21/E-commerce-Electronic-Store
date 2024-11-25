<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navigation.php"; ?>

    <section id="search" style="padding-top:50px; padding-bottom:50px;">
        <div class="container">
            <label for="searchInput">
                <h2>Search</h2>
            </label>
            <div class="d-flex gap-2">
                <input type="search" name="searchInput" id="searchInput" class="form-control" placeholder="Search here..">
                <button class="btn rounded-0" style="background-color:#2250dd; color:white;">Search</button>
            </div>
        </div>

        <div class="container bg-white rounded-1 p-2 my-4">
            <div class="text-center" id="no_search">
                <h3 class="mt-3 mb-0">No Search Result!</h3>
                <img src="./upload/no-search-result.jpg" alt="" class="object-fit" style="width:300px; height:300px;">
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-3" id="search_result">

            </div>
        </div>
    </section>

    <?php require_once "./includes/footer.php" ?>

    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                let vl = $(this).val();
                $("#search_result").empty();

                if (vl !== "") {
                    $("#no_search").hide();
                    $.ajax({
                        url: "./process/manage_product.php",
                        method: "POST",
                        data: {
                            search_query_page: vl
                        },
                        success: function(response) {
                            const data = JSON.parse(response);
                           
                            data['data'].forEach((element, key) => {
                                $("#search_result").append(`
                                <div class="col">
                                    <a href="./productView.php?id=${element['id']}" class="text-decoration-none">
                                        <div class="card h-100 shadow-sm hover:shadow-lg transition-shadow">
                                            <img src="./upload/Product_${element['id']}/${data['images'][key]}" alt="Wireless Earbuds" class="card-img-top">
                                            <div class="card-body">
                                                <h5 class="card-title text-dark">${element['name']}</h5>
                                                <p class="card-text text-primary fw-bold">$${element['price']}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                } else {
                    $("#no_search").show();
                }
            });
        });
    </script>
</body>
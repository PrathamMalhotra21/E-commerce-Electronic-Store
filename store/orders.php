<?php
require_once "./includes/header.php";
?>


<body>
    <?php require_once "./includes/navigation.php"; ?>

    <div class="container py-5">
        <div class="card">
            <div class="card-header">
                <h3>Orders</h3>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:20%">Date Created</th>
                            <th style="width:20%">Order No</th>
                            <th style="width:20%">Total Amount</th>
                            <th style="width:5%">Status</th>
                            <th style="width:15%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="orderTable">

                    </tbody>
                </table>

                <div class="mb-3">
                    <nav class="d-flex justify-content-center" aria-label="Page navigation">
                        <ul class="pagination shadow-sm">

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="orderModalLabel">Order Detail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Product Name</td>
                                <td>Quantity</td>
                                <td>Amount</td>
                            </tr>
                        </thead>
                        <tbody id="orderDetails">
                        </tbody>
                    </table>

                    <div class="mb-3 d-flex gap-2">
                        Address: <div id="address"></div>
                    </div>
                    <div class="mb-3 d-flex gap-2">
                        Delivery Status: <div id="delivery-status" class="badge text-bg-warning"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary rounded-0" onclick="window.print()">Print</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "./includes/footer.php" ?>

    <script>
        let user_id = Number("<?php echo $_SESSION["user_id"] ?>");
        let limit = 10;
        let currentPage = 1;

        function getPagination(page, totalItems, limit) {
            console.log(page, totalItems);
            const total = Math.ceil(totalItems / limit);
            let pagination = '';

            pagination += `<li class="page-item ${page <= 1 ? 'disabled' : ''}"><span class="page-link text-dark px-3 py-2" data-page="${page - 1}">Prev</span></li>`;
            for (let i = 1; i <= total; i++) {
                if (i >= page - 2 && i <= page + 2) {
                    pagination += `<li class="page-item ${page === i ? 'active' : ''}"><span class="page-link text-dark px-3 py-2" data-page="${i}">${i}</span></li>`;
                }
            }
            pagination += `<li class="page-item ${page >= total ? 'disabled' : ''}"><span class="page-link text-dark px-3 py-2" data-page="${page + 1}">Next</span></li>`;
            $(".pagination").html(pagination);
        }

        $(document).on("click", ".pagination span", function(e) {
            e.preventDefault();
            const page = $(this).data("page");
            if (page) {
                currentPage = page;
                loadOrders(user_id, page);
            }
        });

        function loadOrders(id, page = 1) {
            $.ajax({
                url: "./process/manage_orders.php",
                data: {
                    loadClients: id,
                    page: page,
                    limit: limit
                },
                method: "POST",
                success: function(response) {
                    const data = JSON.parse(response);
                    $("#orderTable").html(data.text);
                    getPagination(Number(data.page), Number(data.total), limit);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
        loadOrders(user_id, currentPage);

        $(document).on('click', "#order_id", function() {
            const id = $(this).data("id");
            const address = $(`#address_${id}`).val();
            const status = $(`#status_${id}`).val();
            $("#orderDetails").empty();

            $.ajax({
                url: "./process/manage_orders.php",
                method: "POST",
                data: {
                    get_order: id
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    $("#address").text(address);
                    $("#delivery-status").text(status);
                    data.forEach(elm => {
                        $("#orderDetails").append(`
                    <tr>
                        <td>${elm['name']}</td>
                        <td>${elm['quantity']}</td>
                        <td>$${elm['price']}</td>
                    </tr>
                `);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error: ", error);
                }
            });
        });
    </script>

</body>
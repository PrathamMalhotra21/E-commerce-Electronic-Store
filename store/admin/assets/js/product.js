$(document).ready(function () {
    let productTable = $("#productTable");
    let currentPage = 1;
    let limit = 10;

    function renderPagination(page, limit, totalItmes) {
        const total = Math.ceil(totalItmes / limit);
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

    $(document).on("click", ".pagination span", function (e) {
        e.preventDefault();
        const page = $(this).data("page");
        if (page) {
            currentPage = page;
            loadProductTable(page);
        }
    });

    function loadProductTable(page = 1) {
        productTable.empty();
        $.ajax({
            url: "../process/manage_product.php",
            method: "POST",
            data: {
                get_all_product: true,
                page: page,
                limit: limit
            },
            success: function (response) {
                const data = JSON.parse(response);
                renderPagination(page, limit, data.total);

                data['data'].forEach(vl => {
                    let status_clr = vl['status'] == "active" ? "success" : "warning";
                    productTable.append(`
                    <tr>
                        <td>1</td>
                        <td>${vl['name']}</td>
                        <td>${vl['brand_name']}</td>
                        <td>
                            <p class="text-bg-${status_clr} rounded-2 text-center">${vl['status']}</p>
                        </td>
                        <td>
                            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-dark btn-default btn-sm dropdown-toggle">
                                Action
                            </button>
                            <div class="dropdown-menu py-0" role="menu">
                                <a id="editBtn" href="./addProduct.php?id=${vl['id']}" class="dropdown-item p-2 editBtn"><i class="bi bi-pen"></i> Edit</a>
                                <button id="deleteBtn" data-id="${vl['id']}" class="dropdown-item p-2 deleteBtn"><i class="bi bi-trash3"></i> Delete</button>
                            </div>
                        </td>
                    </tr>
                `);
                });

            },
            error: function (xhr, status, error) {
                console.log("Error: ", error);
                alert(error);
            }
        });
    }
    loadProductTable();

    $(document).on("click", "#deleteBtn", function () {
        let id = $(this).data("id");
        if (confirm("Are you sure you want to delete product")) {
            $.ajax({
                url: "../process/manage_product.php",
                method: "POST",
                data: { deletePrdouct: id },
                success: function (response) {
                    alert(response);
                    loadProductTable(currentPage);
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    alert(error);
                    console.log(error);
                }
            })
        }
    })

    // Search
    $("#search").on("keyup", function (page = 1) {
        productTable.empty();
        let vl = $(this).val();
        $.ajax({
            url: "../process/manage_product.php",
            method: "POST",
            data: {
                search_query: vl
            },
            success: function (response) {
                const data = JSON.parse(response);
                renderPagination(page, limit, data.total);

                data['data'].forEach(vl => {
                    let status_clr = vl['status'] == "active" ? "success" : "warning";
                    productTable.append(`
                    <tr>
                        <td>1</td>
                        <td>${vl['name']}</td>
                        <td>${vl['brand_name']}</td>
                        <td>
                            <p class="text-bg-${status_clr} rounded-2 text-center">${vl['status']}</p>
                        </td>
                        <td>
                            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-dark btn-default btn-sm dropdown-toggle">
                                Action
                            </button>
                            <div class="dropdown-menu py-0" role="menu">
                                <a id="editBtn" href="./addProduct.php?id=${vl['id']}" class="dropdown-item p-2 editBtn"><i class="bi bi-pen"></i> Edit</a>
                                <button id="deleteBtn" data-id="${vl['id']}" class="dropdown-item p-2 deleteBtn"><i class="bi bi-trash3"></i> Delete</button>
                            </div>
                        </td>
                    </tr>
                `);
                });

            },
            error: function (xhr, status, error) {
                console.log("Error: ", error);
                alert(error);
            }
        });
    })


});
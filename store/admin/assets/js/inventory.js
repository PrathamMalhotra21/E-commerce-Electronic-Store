$(document).ready(function () {
    $("#id").val(0);
    let currentPage = 1;
    let limit = 10;

    function getPagination(page, totalItems, limit) {
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

    $(document).on("click", ".pagination span", function (e) {
        e.preventDefault();
        const page = $(this).data("page");
        if (page) {
            currentPage = page;
            loadInventory(page);
        }
    });

    // Load table
    function loadInventory(page = 1) {
        $.ajax({
            url: "../process/manage_inventory.php",
            method: "POST",
            data: { get_inventory: true, page: page, limit: limit },
            success: function (response) {
                const result = JSON.parse(response);
                $("#inventoryTable").html(result.html);
                getPagination(Number(result.page), result.total, limit);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
    loadInventory(currentPage);

    function product_id() {
        $.ajax({
            url: "../process/manage_inventory.php",
            method: "POST",
            data: {
                "get_product_id": true
            },
            success: function (response) {
                $("#product").html(response);
            },
            error: function (xhr, status, error) {
                alert(error);
                console.log(error);
            }
        });
    }
    product_id();

    // Save or Update
    $("#subCategoryForm").on("submit", function (e) {
        e.preventDefault();
        let id = $("#id").val();
        const formData = new FormData(this);
        let save = $("#save").val() == "Update" ? "updateInventory" : "saveInventory";
        formData.append(save, "save");

        if (save !== "updateInventory") {
            for (let [key, value] of formData.entries()) {
                if (key == "" || value == "") {
                    alert("Please enter all feilds");
                    return
                }
            }
        } else {
            formData.append("id", id);
        }

        $.ajax({
            url: "../process/manage_inventory.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response);
                $("#inventoryModal").modal('hide');
                loadInventory(currentPage);
            },
            error: function (xhr, status, error) {
                alert(error);
                console.log(error);
            }
        });

    });

    // Empty Category 
    $("#createInventory").on("click", function () {
        $("#id").val(0);
        $("#product").val("");
        $("#quantity").val("");
        $("#price").val("");
        $("#save").val("Save Changes");
    });

    // Edit Button
    $(document).on("click", "#editBtn", function () {
        $("#inventoryModal").modal('show');
        $("#save").val("Update");
        let id = $(this).data("id");
        $("#id").val(id);
        console.log(save);

        $.ajax({
            url: "../process/manage_inventory.php",
            data: { editInventory: id },
            method: "POST",
            success: function (response) {
                const result = JSON.parse(response);
                $("#product").val(result['product_id']);

                $("#quantity").val(result["quantity"]);
                $("#price").val(result["price"]);
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    });


    // Delete Button
    $(document).on("click", "#deleteBtn", function () {
        if (confirm("Are you sure?")) {
            let id = $(this).data("id");

            $.ajax({
                url: "../process/manage_inventory.php",
                method: "POST",
                data: {
                    deleteInventory: id,
                },
                success: function (response) {
                    loadInventory(currentPage);
                },
                error: function (xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }
    });

    // Search 
    $("#search").on("keyup", function () {
        let vl = $(this).val();
        let page = 1; // or get the current page number
        let limit = 10; // specify the limit or get it dynamically

        $.ajax({
            url: "../process/manage_inventory.php",
            method: "POST",
            data: {
                search_query: vl,
                page: page,
                limit: limit,
            },
            success: function (response) {
                const data = JSON.parse(response);
                getPagination(data.page, data.total, limit);
                $("#inventoryTable").html(data.html);
            },
            error: function (xhr, status, error) {
                alert("Error " + error);
            }
        });
    });


});
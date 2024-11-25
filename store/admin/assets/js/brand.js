$(document).ready(function() {
    $("#id").val(0);
    let currentPage = 1;
    let limit = 10;

    $("#createBrand").on("click", function() {
        $("#name").val("");
        $("#description").val("");
        $("#save").val("Save Changes");
    });

    // Pagination
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
            loadBrand(page);
        }
    });

    // Load Banner
    function loadBrand(page = 1) {
        $.ajax({
            url: "../process/manage_brand.php",
            method: "POST",
            data: { getBrand: true, page: page, limit: limit },
            success: function (response) {
                const result = JSON.parse(response);
                $("#brandTable").html(result.html);
                getPagination(result.page, result.total, limit);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    loadBrand(currentPage);

    // Save
    $("#brandFrom").on("submit", function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let save = $("#save").val() == "Update" ? "updateBrand" : "saveBrand";
        formData.append(save, "save");

        if (save !== "updateBrand") {
            for (let [key, value] of formData.entries()) {
                if (key == "" || value == "") {
                    alert("All the feilds are required");
                    $("#error_msg").show();
                    return
                }
            }
        }

        $.ajax({
            url: "../process/manage_brand.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                loadBrand(currentPage);
                $("#brandModal").modal("hide");
            },
            error: function(xhr, status, error) {
                alert(error);
                console.log(error);
            }
        });

    });

    // Edit 
    $(document).on("click", "#editBtn", function() {
        $("#brandModal").modal('show');
        $("#save").val("Update");
        let id = $(this).data("id");
        $("#id").val(id);
        console.log(id);

        $.ajax({
            url: "../process/manage_brand.php",
            data: {editbrand: id},
            method: "POST",
            success: function(response) {
                const result = JSON.parse(response);
                $("#name").val(result["brand_name"]);
                $("#description").val(result["description"]);
                console.log(result['brand_name'], result['description']);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        })
    });

    // Delete Button
    $(document).on("click", "#deleteBtn", function() {
        if (confirm("Are you sure?")) {
            let id = $(this).data("id");

            $.ajax({
                url: "../process/manage_brand.php",
                method: "POST",
                data: {
                    deleteBrand: true,
                    id: id
                },
                success: function(response) {
                    loadBrand(currentPage);
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }
    });

    // Search 
    $("#search").on("keyup", function() {
        let vl = $(this).val();
        $.ajax({
            url: "../process/manage_brand.php",
            method: "POST",
            data: {
                search_query: true,
                query: vl
            },
            success: function(response) {
                $("#brandTable").html(response);
            },
            error: function(xhr, status, error) {
                alert("Error " + error);
            }
        })
    });
    
});
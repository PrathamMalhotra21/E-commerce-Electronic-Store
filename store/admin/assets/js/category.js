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

    function loadCategories(page = 1) {
        $.ajax({
            url: "../process/manage_category.php",
            method: "POST",
            data: { get_categories: true, page: page, limit: limit },
            success: function (response) {
                const result = JSON.parse(response);
                $("#tbody").html(result.html);
                getPagination(result.page, result.total, limit);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    loadCategories(currentPage);

    $(document).on("click", ".pagination span", function (e) {
        e.preventDefault();
        const page = $(this).data("page");
        if (page) {
            currentPage = page;
            loadCategories(page);
        }
    });

    // Save or Update
    $("#categoryForm").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let save = $("#save").val() == "Update" ? "update_category" : "save_category";
        formData.append(save, "save");

        // Check if fields is empty or not
        if (save === "save_category") { 
            for (let [key, value] of formData.entries()) {
                if (key == "" || value == "") {
                    alert("Please enter all feilds");
                    return
                }
            }
   
            const file = formData.get("img");
            if (!file || file.size === 0) {
                alert("Please upload an image.");
                return;
            }
        } else {
            id = $("#id").val();
            formData.append("id", id);
        }

        $.ajax({
            url: "../process/manage_category.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                loadCategories();
                $("#categoryModal").modal("hide");
                alert(response);
                if (save == "Update") {
                    $("#save").text("Save Changes");
                }
            },
            error: function (xhr, status, error) {
                alert("Error: " + error);
            }
        });

    });

    // Empty Category 
    $("#createCategory").on("click", function() {
        $("#name").val("");
        $("#description").val("");
        $("#save").val("Save Changes");
    });

    // Edit Button
    $(document).on("click", "#editBtn", function() {
        $("#categoryModal").modal('show');
        $("#save").val("Update");
        let id = $(this).data("id");
        $("#id").val(id);

        $.ajax({
            url: "../process/manage_category.php",
            data: {editCategory: id},
            method: "POST",
            success: function(response) {
                const result = JSON.parse(response);
                $("#name").val(result["category_name"]);
                $("#description").val(result["description"]);
            },
            error: function(xhr, status, error) {
                alert();
            }
        })
    });

    // Delete Button
    $(document).on("click", "#deleteBtn", function() {
        if (confirm("Are you sure?")) {
            let id = $(this).data("id");

            $.ajax({
                url: "../process/manage_category.php",
                method: "POST",
                data: {
                    deleteCategory: true,
                    id: id
                },
                success: function(response) {
                    loadCategories(currentPage);
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
            url: "../process/manage_category.php",
            method: "POST",
            data: {
                search_query: true,
                query: vl
            },
            success: function(response) {
                $("#tbody").html(response);
            },
            error: function(xhr, status, error) {
                alert("Error " + error);
            }
        })
    });

});
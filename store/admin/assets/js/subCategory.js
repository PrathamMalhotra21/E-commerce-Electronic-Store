$(document).ready(function () {
    $("#id").val(0);
    let currentPage = 1;
    let limit = 10;

    // Get Category
    function get_categroy() {
        $.ajax({
            url: "../process/manage_subcategory.php",
            method: "POST",
            data: {
                get_all_category: true
            },
            success: function (response) {
                $("#category").html(response);
            },
            error: function (xhr, status, error) {
                alert("Error: " + error);
            }
        });
    }
    get_categroy();

    // Pagenation
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
            loadSubCategories(page);
        }
    });

    // Load Sub Category to the table
    function loadSubCategories(page = 1) {
        $.ajax({
            url: "../process/manage_subcategory.php",
            method: "POST",
            data: {
                get_sub_category: true,
                page: page,
                limit: limit
            },
            success: function (response) {
                const result = JSON.parse(response);
                $("#subCategoryTable").html(result.html);
                getPagination(result.page, result.total, limit);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
    loadSubCategories(currentPage);

    // Empty the modal
    $("#subCategorySaveBtn").on("click", function () {
        $("#name").val("");
        $("#description").val("");
        $("#save").val("Save Changes");
        $("#save").text("Save Changes");
    });

    // Save Subb Category
    $("#subCategoryForm").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let save = $("#save").val() == "Update" ? "Update_subCategory" : "Save_subCategory";
        formData.append(save, "save");

        if (save !== "Update_subCategory") {
            // Check empty feilds
            for (let [key, value] of formData.entries()) {
                if (key == "" || value == "") {
                    alert("Please fill all the feilds");
                    return;
                }
            }
        } else {
            formData.append(id, $("#id").val());
        }

        $.ajax({
            url: "../process/manage_subcategory.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $("#subCategoryModal").modal("hide");
                alert(response);
                if (save == "Update") {
                    $("#save").text("Save Changes");
                    $("#save").val("Save Changes");
                }
                loadSubCategories(currentPage);
            },
            error: function (xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });

    // Edit the Sub Categroy
    $(document).on("click", "#editBtn", function () {
        $("#subCategoryModal").modal('show');
        $("#save").val('Update');
        let id = $(this).data("id");
        $("#id").val(id);
        console.log(id);

        $.ajax({
            url: "../process/manage_subcategory.php",
            data: { editSubCategory: id },
            method: "POST",
            success: function (response) {
                const result = JSON.parse(response);
                $("#name").val(result["sub_category_name"]);
                $("#description").val(result["description"]);
            },
            error: function (xhr, status, error) {
                alert();
            }
        })
    });

    // Delete Button
    $(document).on("click", "#deleteBtn", function() {
        if (confirm("Are you sure?")) {
            let id = $(this).data("id");

            $.ajax({
                url: "../process/manage_subcategory.php",
                method: "POST",
                data: {
                    deleteSubCategory: true,
                    id: id
                },
                success: function(response) {
                    loadSubCategories(currentPage);
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
            url: "../process/manage_subcategory.php",
            method: "POST",
            data: {
                search_query: true,
                query: vl
            },
            success: function(response) {
                $("#subCategoryTable").html(response);
            },
            error: function(xhr, status, error) {
                alert("Error " + error);
            }
        })
    });

});
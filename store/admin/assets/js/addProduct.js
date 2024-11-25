$(document).ready(function () {
    const formData = new FormData();
    const previewContainer = $('#preview');

    // Form handling
    $("#productImg").on("change", function () {
        const files = this.files;
        // Add each file to formData
        for (let i = 0; i < files.length; i++) {
            formData.append(`file-${i}`, files[i]);
        }

        displayPreviews();
    });

    function displayPreviews() {
        previewContainer.empty();

        formData.forEach((file, key) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.append(`
                <div id="${key}" class="d-flex flex-row justify-content-around align-items-center mb-2">
                    <img src="${e.target.result}" alt="" style="border-radius: 8px; overflow:hidden; width: 200px; height: 200px; border: 5px solid #e6e6e6;">
                    <button class="btn btn-outline-danger delete-btn" data-key="${key}" type="button" style="width:50px; height: 50px;"><i class="bi bi-trash3"></i></button>
                </div>
            `);
            }
            reader.readAsDataURL(file);
        });
    };

    $(document).on('click', '.delete-btn', function () {
        const key = $(this).data('key');
        formData.delete(key);
        $(`#${key}`).remove(); 
    });

    // Get categroy_id, brand_id
    function get_ids() {
        $.ajax({
            url: "../process/manage_product.php",
            data: {get_all_ids: true},
            method: "POST",
            success: function(response) {
                const data = JSON.parse(response);
                $("#productCategory").html(data.category);
                $("#productBrand").html(data.brand);
                if (selectedCategoryId) {
                    $("#productCategory").val(selectedCategoryId);
                }
                if (selectedBrandId) {
                    $("#productBrand").val(selectedBrandId);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
                alert(error);
            }
        });
    }
    get_ids();

    $("#productCategory").on("change", function() {
        let id = $(this).val();
        $.ajax({
            url: "../process/manage_product.php",
            data: {get_all_sub_category: id},
            method: "POST",
            success: function(response) {
                $("#productSubCategory").html(response);

                if (selectedSubCategoryId) {
                    $("#productSubCategory").val(selectedSubCategoryId);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
                alert(error);
            }
        })
    });

    $('#addProductForm').on("submit", function (e) {
        e.preventDefault();
        const formDt = new FormData(this);
        let save = $("#addProductBtn").val() == "Update" ? "updateProduct" : "saveProduct";
    
        if (save !== "updateProduct") {
            for (let [key, value] of formDt.entries()) {
                if (key == "productSubCategory") {
                    continue;
                } else if (key == "" || value == "") {
                    alert("Please fill all the fields");
                    return;
                }
            }
            formDt.append(save, "save");
        } else {
            formDt.append("id", $("#id").val());
            formDt.append(save, "save");
        }

        $.ajax({
            url: "../process/manage_product.php",
            method: "POST",
            data: formDt,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                window.location.href = "./product.php";
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    });
    
    

    $('#specs').summernote({
        placeholder: 'Product Description',
        tabsize: 2,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

});
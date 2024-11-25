$(document).ready(function () {
    $("#id").val("0");
    $("#bannerForm").on("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const save = $("#save").val() == "Update" ? "update_banner" : "save_banner";
        formData.append(save, "save");

        if (save == "Update") {
            for (let [key, value] of formData.entries()) {
                if (key == "" || value == "") {
                    alert("Please fill all the fields");
                    return
                }
            }
        } else {
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
        } 

        $.ajax({
            url: "../process/manage_banner.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                ("#bannerModal").modal("hide");
                loadBanner();
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });

    });

    $("#createBanner").on("click", function() {
        $("#save").val("save");
        $("#heading").val("");
        $("#title").val("");
        $("#badge").val("");
        $("#btnText").val("");
    });

    function loadBanner() {
        $.ajax({
            url: "../process/manage_banner.php",
            method: "POST",
            data: {
                load_banner: true
            },
            success: function(response) {
                $("#bannerTable").html(response);
            },
            error: function(xhr, status, error) {
                alert(error);
                console.log(error);
            }
        });
    }
    loadBanner();

    $(document).on("click","#editBtn", function() {
        let id = $(this).data("id");
        $("#id").val(id);
        $("#bannerModal").modal("show");
        $("#save").val("Update");

        $.ajax({
            url: "../process/manage_banner.php",
            method: "POST",
            data: {
                edit_banner: id
            },
            success: function(response) {
                const data = JSON.parse(response);
                $("#heading").val(data.heading);
                $("#title").val(data.title);
                $("#badge").val(data.badge_text);
                $("#btnText").val(data.btn_text);
            },
            error: function(xhr, status, error) {
                alert(error);
                console.log(error);
            }
        });
    });

    $(document).on("click", "#deleteBtn", function() {
        let id = $(this).data("id");
        if (confirm("Are you sure you want to delete")) {
            $.ajax({
                url: "../process/manage_banner.php",
                method: "POST",
                data: {delete_banner: id},
                success: function(response) {
                    alert(response);
                    loadBanner();
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
    });



    $('#privacyPolicy').summernote({
        placeholder: 'Privacy Policy',
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
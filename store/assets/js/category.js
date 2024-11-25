$(document).ready(function() {
    function loadCategories() {
        $.ajax({
            url: "./process/manage_category.php",
            method: "POST",
            data: {
                get_all_categroy: 'active'
            },
            success: function(response) {
                $("#allCategroy").html(response);
            },
            error: function(xhr, status, error) {
                alert("ERROR: " + error);
            }
        });
    }

    loadCategories();
});
$(document).ready(function() {
    // Fetch
    function fetchAdmin() {
        $.ajax({
            url: "../process/manage_user.php",
            method: "POST",
            data: {
                "fetchAdmin": true
            },
            success: function(response) {
                const data = JSON.parse(response);
                $("#firstName").val(data['first_name']);
                $("#lastName").val(data['last_name']);
                $("#username").val(data['username']);
            },
            error: function(xhr, status, error) {
                alert(error);
                console.log(error);
            }
        });
    }
    fetchAdmin();

    // Update
    $("#updateProfile").on("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append("updateAdmin", "admin");

        $.ajax({
            url: "../process/manage_user.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response);
            },
            error: function(xhr, status, error) {
                alert(error);
                console.log(error);
            }
        });

    });

});
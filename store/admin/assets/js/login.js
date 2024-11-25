$(document).ready(function() {
    $("#adminLogin").on("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append("adminLogin", "admin");
        
        $.ajax({
            url: "../process/manage_user.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                if (response == "success") {
                    window.location.href = "./index.php";
                } else {
                    alert(response);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });

    });
});
$(document).ready(function() {
    $("#addToCart").on('click', function() {
        const id = $(this).data("id");
        
        $.ajax({
            url: "./process/manage_cart.php",
            method: "POST",
            data: {addCart: id},
            success: function(response) {
                alert("Product added to cart!");
                $("#cartQty").text(response);
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    });

    $("#buyNow").on('click', function() {
        const id = $(this).data("id");
        
        $.ajax({
            url: "./process/manage_cart.php",
            method: "POST",
            data: {addCart: id},
            success: function(response) {
                if (response) {
                    window.location.href = "./cart.php";
                }
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    });
});
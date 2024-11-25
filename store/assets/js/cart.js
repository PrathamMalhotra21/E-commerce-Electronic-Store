$(document).ready(function () {
    // Empty the cart
    $("#emptyCart").on("click", function () {
        $.ajax({
            url: "./process/manage_cart.php",
            method: "POST",
            data: { emptyCart: true },
            success: function (response) {
                alert("Cart is empty");
                window.location.reload();
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    });

    // Delete Product
    $(document).on("click", "#deleteProduct", function () {
        const id = $(this).data("id");

        $.ajax({
            url: "./process/manage_cart.php",
            method: "POST",
            data: { deleteProduct: id },
            success: function (response) {
                alert("Cart is empty");
                window.location.reload();
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    });

    // Inc product
    $(document).on("click", "#incProduct", function () {
        const id = $(this).data("id");

        $.ajax({
            url: "./process/manage_cart.php",
            method: "POST",
            data: { addCart: id },
            success: function (response) {
                window.location.reload();
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    });

    // Dec Product
    $(document).on("click", "#decProduct", function () {
        const id = $(this).data("id");

        $.ajax({
            url: "./process/manage_cart.php",
            method: "POST",
            data: { decProduct: id },
            success: function (response) {
                console.log(response);
                if (Number(response) < 1) {
                    window.location.reload();
                } else {
                    $(`#qty_product_${id}`).val(response);
                }
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    });

});
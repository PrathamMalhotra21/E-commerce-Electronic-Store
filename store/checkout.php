<?php
require_once "./includes/header.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

// Calculate the total order amount
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['qty'];
}
?>

<body>
    <?php require_once "./includes/navigation.php"; ?>

    <section style="padding-top: 50px; padding-bottom: 50px;">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3>Checkout</h3>
                </div>
                <div class="card-body">
                    <form id="checkout-form">
                        <!-- User Address -->
                        <div class="mb-3">
                            <input type="hidden" name="amount" id="amount" value="<?php echo $totalPrice; ?>">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $_SESSION['user_address']; ?></textarea>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-3">
                            <label class="form-label">Select Payment Method:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal_option" value="paypal" required>
                                <label class="form-check-label" for="paypal_option">PayPal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod_option" value="cod" required>
                                <label class="form-check-label" for="cod_option">Cash on Delivery</label>
                            </div>
                        </div>

                        <!-- PayPal Button -->
                        <div id="paypal-button-container" style="display: none;">
                        </div>

                        <!-- COD Button -->
                        <div id="cod-button" style="display: none;">
                            <button type="button" class="btn btn-primary">Place Order (COD)</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "./includes/footer.php"; ?>

    <script src="https://www.paypal.com/sdk/js?client-id=Ad7mJ4kQtQ762W67Z9jeaOBHzcbl0-e5YZ0juTWVPlkUwYP2gDTNlgCYH-Zh1qRq3cUIZj8mTBswQOnK&currency=USD"></script>
    <script>
        $(document).ready(function() {
            const $paypalOption = $("#paypal_option");
            const $codOption = $("#cod_option");
            const $paypalButtonContainer = $("#paypal-button-container");
            const $codButton = $("#cod-button");
            const amount = $("#amount").val();

            $("input[name='payment_method']").on('change', function() {
                if ($paypalOption.is(":checked")) {
                    $paypalButtonContainer.show();
                    $codButton.hide();
                } else if ($codOption.is(":checked")) {
                    $paypalButtonContainer.hide();
                    $codButton.show();
                }
            });

            // Cash on Delivery
            $codButton.find("button").on("click", function() {
                const address = $("#address").val();
                if (!address.trim()) {
                    alert("Please provide a valid address.");
                    return;
                }

                $.ajax({
                    url: "./process/process_payment.php",
                    method: "POST",
                    data: {
                        payment_method: "cash",
                        amount: amount,
                        address: address
                    },
                    success: function(response) {
                    console.log(response);
                        const result = JSON.parse(response);
                        if (result.success) {
                            alert("Order placed successfully!");
                            window.location.href = "./index.php";
                        } else {
                            alert(result.message || "Error placing order.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("An error occurred. Please try again.");
                    }
                });
            });

            // PayPal Integration
            paypal.Buttons({
                createOrder: function(data, action) {
                    return action.order.create({
                        purchase_units: [{
                            amount: {
                                value: amount
                            }
                        }]
                    });
                },
                onApprove: function(data, action) {
                    return action.order.capture().then(function(details) {
                        const address = $("#address").val();
                        if (!address.trim()) {
                            alert("Please provide a valid address.");
                            return;
                        }

                        // Send PayPal details to backend
                        $.ajax({
                            url: "./process/process_payment.php",
                            method: "POST",
                            data: {
                                payment_method: "paypal",
                                amount: amount,
                                address: address,
                                transaction_id: details.id,
                                payer_email: details.payer.email_address
                            },
                            success: function(response) {
                                const result = JSON.parse(response);
                                if (result.success) {
                                    alert("Payment successful!");
                                    window.location.href = "./index.php";
                                } else {
                                    alert(result.message || "Error processing payment.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                                alert("An error occurred. Please try again.");
                            }
                        });
                    });
                },
                onError: function(err) {
                    console.error('PayPal error:', err);
                    alert('An error occurred during the payment process. Please try again.');
                }
            }).render('#paypal-button-container');
        });
    </script>
</body>
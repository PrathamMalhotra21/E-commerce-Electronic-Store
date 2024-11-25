<?php
require_once "./includes/header.php";
$totalPrice = 0;
?>

<body>
    <?php require_once "./includes/navigation.php"; 
    ?>

    <section style="padding-top: 50px; padding-bottom: 50px;">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Your Cart</h3>
                        <button id="emptyCart" class="btn btn-outline-dark rounded-0"><i class="bi bi-trash"></i> Empty Cart</button>
                    </div>
                </div>

                <?php if (!isset($_SESSION["cart"]) ||  count($_SESSION["cart"]) <= 0): ?>

                <!-- Empty Cart Message -->
                <div class="card-body text-center">
                    <h3>Your cart is empty!</h3>
                    <a href="./category.php" class="my-3 rounded-0 btn" style="background-color: #2250dd; color: white;">Shop Now</a>
                </div>
                <?php else: ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10%;">Action</th>
                                    <th class="text-center" style="width: 15%;">Image</th>
                                    <th>Product</th>
                                    <th class="text-center" style="width: 25%;">Quantity</th>
                                    <th class="text-center" style="width: 10%;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($_SESSION['cart'] as $value): ?>
                                <tr>
                                    <td class="text-center align-middle" data-label="Action">
                                        <button data-id="<?php echo $value['id'] ?>" id="deleteProduct" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                    <td class="text-center" data-label="Image">
                                        <img src="<?php echo $value['img'] ?>" alt="Product" class="img-fluid">
                                    </td>
                                    <td class="align-middle" data-label="Product">
                                        <h6 class="mb-0"><?php echo $value['name'] ?></h6>
                                        <small class="text-muted">Price: $<?php echo $value['price'] ?></small>
                                    </td>
                                    <td class="text-center align-middle" data-label="Quantity">
                                        <div class="input-group input-group-sm justify-content-center">
                                            <button data-id="<?php echo $value['id'] ?>" id="decProduct" class="btn btn-outline-secondary" type="button">-</button>
                                            <input type="text" class="form-control text-center" style="max-width: 60px;" id="qty_product_<?php echo $value['id'] ?>" value="<?php echo $value['qty'] ?>">
                                            <button data-id="<?php echo $value['id'] ?>" id="incProduct" class="btn btn-outline-secondary" type="button">+</button>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle" data-label="Total">$<?php echo $value['price'] * $value['qty'] ?></td>
                                    <?php $totalPrice += ($value['price'] * $value['qty']) ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-center" data-label="Total"><strong>Total:</strong></td>
                                    <td class="text-center" data-label="Total"><strong>$<?php echo $totalPrice ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <a href="category.php" class="btn btn-outline-secondary rounded-0">
                                <i class="bi bi-arrow-left"></i> Continue Shopping
                            </a>
                        </div>
                        <div class="">
                            <a href="./checkout.php" class="btn rounded-0" style="background-color: #2250dd; color: white;">
                                Proceed to Checkout <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php require_once "./includes/footer.php" ?>
    <script src="./assets/js/cart.js"></script>
</body>
<?php
require_once "./includes/header.php";
require_once "../Classes/User.php";

$orders = new User();

$order_id = isset($_GET["order_id"]) ? $_GET["order_id"] : null;
$results = $orders->client_order($order_id);
$order_detail = $orders->get_user_order($order_id);

?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <section class="main-content">
        <div class="card d-flex flex-column p-0 my-3">
            <div class="card-header">
                <h3>Update</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th class="col-3">Qty</th>
                                <th class="col-4">Product</th>
                                <th class="col-3">Price</th>
                                <th class="col-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $result): ?>
                                <tr>
                                    <td class="col-3"><?php echo $result['quantity']; ?></td>
                                    <td class="col-4"><?php echo $result['name']; ?></td>
                                    <td class="col-3"><?php echo number_format($result['price'], 2); ?></td>
                                    <td class="col-2"><?php echo number_format($result['quantity'] * $result['price'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Payment Method <span class="badge bg-primary"><?php echo $order_detail['payment_method'] ?></span></div>
                <div>Payment Status <span class="badge bg-success"><?php echo $order_detail['payment_status'] ?></span></div>
                <div>Status <span class="badge bg-info"><?php echo $order_detail['status'] ?></span></div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
            </div>
        </div>
        </div>
    </section>

    <div class="modal" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../process/manage_orders.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="pending">pending</option>
                                <option value="processing">processing</option>
                                <option value="completed">completed</option>
                                <option value="cancelled">cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="updateStatus" value="true" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script src="./assets/js/orders.js"></script>

</body>
<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <section class="main-content">
        <div class="mb-3 p-2 bg-white rounded-3">
            <div class="d-flex justify-content-between">
                <h2>Inventory</h2>
                <button id="createInventory" class="rounded-3 p-2 text-decoration-none bg-opacity-10 bg-primary" style="border:none;" data-bs-toggle="modal" data-bs-target="#inventoryModal">
                    <p class="text-primary mb-0 align-item-center align-middle"><i class="bi bi-plus-circle"></i> Create New</p>
                </button>
            </div>
        </div>

        <div class="mb-3 p-2 bg-white rounded-3">
            <input type="text" name="search" id="search" class="form-control w-50" placeholder="Search here">
        </div>

        <div class="mb-3 p-2 bg-white rounded-3">
            <table class="table">
                <colgroup>
                    <col width="10%">
                    <col width="30%">
                    <col width="20%">
                    <col width="20%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Stocks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="inventoryTable">
                </tbody>
            </table>
        </div>

        <div class="mb-3">
            <nav class="d-flex justify-content-center" aria-label="Page navigation">
                <ul class="pagination shadow-sm">
                </ul>
            </nav>
        </div>

    </section>

    <div class="modal fade" id="inventoryModal" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="inventoryModalLabel">Inventory</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="display: block;"></button>
                </div>
                <form id="subCategoryForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id" value="0">
                            <label for="product">Product</label>
                            <select class="form-select" id="product" name="product_id">
                                <option value="">Choose a product</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity">Inventory</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" value="">
                        </div>
                        <div class="mb-3">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="amount" id="price" value="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" value="save" name="save" id="save" class="btn btn-outline-success rounded-0">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./assets/js/inventory.js"></script>

</body>
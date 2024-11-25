<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <section class="main-content">
        <div class="mb-3 p-2 bg-white rounded-3">
            <div class="d-flex justify-content-between">
                <h2>Brand</h2>
                <button id="createBrand" class="rounded-3 p-2 text-decoration-none bg-opacity-10 bg-primary" style="border:none;" data-bs-toggle="modal" data-bs-target="#brandModal">
                    <p class="text-primary mb-0 align-item-center align-middle"><i class="bi bi-plus-circle"></i> Add Brand</p>
                </button>
            </div>
        </div>

        <div class="mb-3 bg-white p-2 rounded-2">
            <input type="text" name="search" id="search" class="form-control" placeholder="Search here">
        </div>

        <div class="mb-3 p-2 bg-white rounded-3">
            <table class="table">
                <colgroup>
                    <col width="5%">
                    <col width="20%">
                    <col width="20%">
                    <col width="30%">
                    <col width="10%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Brand</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="brandTable">
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

    <div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="brandModalLabel">Brand</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="display: block;"></button>
                </div>
                <form id="brandFrom">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="" id="id">
                            <label for="name">Brand Name</label>
                            <input type="text" class="form-control" name="brand_name" id="name" value="">
                        </div>
                        <div class="mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" value=""></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" id="save" value="save" class="btn btn-outline-success rounded-0">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./assets/js/brand.js"></script>

</body>
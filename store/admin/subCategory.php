<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <section class="main-content">
        <div class="mb-3 p-2 px-3 bg-white rounded-3">
            <div class="d-flex justify-content-between">
                <h2>Sub Category</h2>
                <button id="subCategorySaveBtn" class="rounded-3 p-2 text-decoration-none bg-opacity-10 bg-primary" style="border:none;" data-bs-toggle="modal" data-bs-target="#subCategoryModal">
                    <p class="text-primary mb-0 align-item-center align-middle"><i class="bi bi-plus-circle"></i> Add Sub Category</p>
                </button>
            </div>
        </div>

        <div class="mb-3 bg-white p-2 rounded-2">
            <input type="text" name="search" id="search" class="form-control" placeholder="Search here">
        </div>

        <!-- Table -->
        <div class="mb-3 p-2 bg-white rounded-3">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 15%;">Sub Category</th>
                        <th style="width: 15%;">Description</th>
                        <th style="width: 5%;">Status</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody id="subCategoryTable">
                    <!-- Enter Sub Category Here -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mb-3">
            <nav class="d-flex justify-content-center" aria-label="Page navigation">
                <ul class="pagination shadow-sm">
                </ul>
            </nav>
        </div>

    </section>

    <!-- Modal -->
    <div class="modal fade" id="subCategoryModal" tabindex="-1" aria-labelledby="subCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="subCategoryModalLabel">Sub Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="display: block;"></button>
                </div>
                <form id="subCategoryForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="" id="id">
                        <div class="mb-3">
                            <label for="category">Category</label>
                            <select class="form-select" name="category" id="category">
                                <option value="">Choose a category</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name">Sub Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="">
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
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" id="save" value="save" class="btn btn-outline-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./assets/js/subCategory.js"></script>

</body>
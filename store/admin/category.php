<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <section class="main-content">
        <div class="mb-3 p-2 bg-white rounded-3">
            <div class="d-flex justify-content-between">
                <h2>Category</h2>
                <button class="rounded-3 p-2 text-decoration-none bg-opacity-10 bg-primary" id="createCategory" style="border:none;" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <p class="text-primary mb-0 align-item-center align-middle"><i class="bi bi-plus-circle"></i> Add Category</p>
                </button>
            </div>
        </div>

        <div class="mb-3 bg-white p-2 rounded-2">
            <input type="text" name="search" id="search" class="form-control" placeholder="Search category name">
        </div>

        <div class="mb-3 p-2 bg-white rounded-3">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 15%;">Description</th>
                        <th style="width: 15%;">Image</th>
                        <th style="width: 5%;">Status</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <!-- Insert the data here -->
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

    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="categoryModalLabel">Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="display: block;"></button>
                </div>
                <form id="categoryForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="" id="id">
                        <div class="mb-3">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="">
                        </div>
                        <div class="mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" value=""></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="img">Image</label>
                            <input type="file" name="img" id="img" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="save" id="save" value="Save changes" class="btn btn-outline-success rounded-0"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./assets/js/category.js"></script>

</body>
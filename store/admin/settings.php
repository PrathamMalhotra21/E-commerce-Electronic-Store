<?php
require_once "./includes/header.php";
?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <div class="main-content">
        <div class="mb-3 p-2 px-3 bg-white rounded-3 shadow-sm">
            <h2>System Information</h2>
        </div>

        <div class="card p-0" style="flex-direction: column;">
            <div class="card-header d-flex justify-content-between">
                <h4>Banner</h4>
                <button id="createBanner" data-bs-toggle="modal" data-bs-target="#bannerModal" class="btn rounded-0 text-uppercase text-white" style="background-color: #2250dd;">Add Banner</button>
            </div>
            <div class="card-body px-2">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 20%;">Heading</th>
                                <th style="width: 15%;">Title</th>
                                <th style="width: 15%;">Badge Text</th>
                                <th style="width: 10%;">Btn Text</th>
                                <th style="width: 20%;">Image</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="bannerTable">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Banner</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="display:block;"></button>
                </div>
                <form id="bannerForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id" value="0">
                            <label for="heading" class="form-label">Heading</label>
                            <input type="text" name="heading" id="heading" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="badge" class="form-label">Badge Text</label>
                            <input type="text" name="badge" id="badge" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="btnText" class="form-label">Badge Text</label>
                            <input type="text" name="btnText" id="btnText" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="bannerImg" class="form-label">Banner Image</label>
                            <input type="file" name="bannerImg" id="bannerImg" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" id="save" value="save" class="btn btn-outline-primary rounded-0">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./assets/js/systemInfo.js"></script>

</body>
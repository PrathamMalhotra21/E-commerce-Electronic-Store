<?php
require_once "./includes/header.php";
require_once "../Classes/Product.php";
$product = new Product();

$id = "";
$results;
if (isset($_GET['id'])) {
    $id = $_GET["id"];
    $results = $product->get_product_id($id);
}


?>

<body>
    <?php require_once "./includes/navbar.php" ?>
    <section class="main-content">
        <div class="mb-3 p-2 px-3 bg-white rounded-3">
            <div class="d-flex justify-content-between">
                <?php if (!isset($_GET['id'])): ?>
                    <h2>Add Products</h2>
                <?php else: ?>
                    <h2>Edit Products</h2>
                <?php endif; ?>
            </div>
        </div>

        <form id="addProductForm">
            <div class="mb-3 p-2 px-3 bg-white rounded-3">
                <div class="mb-3">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" name="productName" value="<?php echo $results["name"] ?? "" ?>" id="productName" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="productBrand" class="form-label">Brand</label>
                    <select name="productBrand" id="productBrand" class="form-select">
                        <option value="">Choose a Brand</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="productCategory" class="form-label">Category</label>
                    <select name="productCategory" id="productCategory" class="form-select">
                        <option value="">Choose Categroy</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="productSubCategory" class="form-label">Sub Category</label>
                    <select name="productSubCategory" id="productSubCategory" class="form-select">
                        <option value="">Choose a Sub Categroy</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="specs" class="form-label">Specs</label>
                    <textarea name="specs" id="specs" cols="30" rows="2" class="form-control no-resize"><?php echo $results["specs"] ?? "" ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 p-2 px-3 bg-white rounded-3">
                <label for="productImg" class="form-label">Product Image</label>
                <input type="file" name="productImg[]" id="productImg" class="form-control" multiple>
                <div class="mb-3 p-2" id="preview">
                </div>
                <div class="mb-3 p-2">
                    <?php if (isset($_GET['id'])) { 
                        $dir = "../upload/Product_" . $id;
                        $files = scandir($dir);
                        $productImages = array_filter($files, function($file) {
                            return $file !== '.' && $file !== '..';
                        });
                        
                        foreach ($productImages as $image) {
                            echo "<div class='d-flex flex-row justify-content-around align-items-center mb-2'>";
                            echo "<img src='{$dir}/{$image}' alt='' style='border-radius: 8px; overflow:hidden; width: 200px; height: 200px; border: 5px solid #e6e6e6;'>";
                            echo "<button class='btn btn-outline-danger' onclick='delete_img(\"{$dir}/{$image}\")' id='deleteImg' type='button' style='width:50px; height:50px;'><i class='bi bi-trash3'></i></button>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="mb-3 p-2 px-3 bg-white rounded-3">
                <div class="btn-group w-100">
                    <?php if(isset($_GET['id'])): ?>
                        <input type='hidden' name='id' id='id' value="<?php echo $id ?>">;
                    <?php endif; ?>
                    <button type="submit" id="addProductBtn" name="save" value="<?php echo isset($_GET['id']) ? "Update" : "save" ?>" class="btn btn-outline-success rounded-0">Submit</button>
                    <a href="./product.php" class="btn btn-outline-danger rounded-0">Discard</a>
                </div>
            </div>
        </form>

    </section>

    <script>
        var selectedCategoryId = "<?php echo $results['category_id'] ?? ''; ?>";
        var selectedBrandId = "<?php echo $results['brand_id'] ?? ''; ?>";
        var selectedSubCategoryId = "<?php echo $results['sub_category_id'] ?? ''; ?>";

        function delete_img(key) {
            if (confirm("Are you sure you want to delete image")) {
                $.ajax({
                url: "../process/manage_product.php",
                method: "POST",
                data: {delete_img: key},
                success: function(response) {
                    alert(response);
                    window.location.reload();
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
            }
        }
    </script>

    <script src="./assets/js/addProduct.js"></script>
</body>
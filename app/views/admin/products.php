<?php $this->view("admin/header", $data); ?>
<style>
    .add-category {
        background-color: #EEE;
        width: 400px;
        height: 300px;
    }
</style>
<?php $this->view("admin/sidebar") ?>
<h3><i class="fa fa-angle-right"></i> Products</h3>
<div class="row mt">
    <div class="col-lg-12">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <table class="table table-striped table-advance table-hover table-responsive text-center">
                        <h4><i class="fa fa-angle-right"></i> All Products</h4>
                        <hr>
                        <thead class="text-center">
                            <tr class="text-center">
                                <th><i class="fa fa-bullhorn"></i>Product Name</th>
                                <th><i class="fa fa-bullhorn"></i>Quantity</th>
                                <th><i class="fa fa-bullhorn"></i>Price</th>
                                <th><i class="fa fa-bullhorn"></i>Image</th>
                                <th><i class="fa fa-bullhorn"></i>Category Name</th>
                                <th class="text-center"><i class="fa fa-edit"></i> Status</th>
                                <th class="text-center">Control</th>
                            </tr>
                        </thead>
                        <tbody class="table-body text-center">
                            <?= $data['data'] ?>
                        </tbody>
                    </table>
                </div><!-- /content-panel -->
                <div class="add-product" style="display: none;">
                    <form method="POST" class="add-product-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text" name="description" id="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" min="1">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price">
                        </div>
                        <div class="form-group">
                            <label for="main_image">Main Image</label>
                            <input type="file" name="main_image" id="main_image" accept=".jpeg , .png  , .jpg">
                        </div>
                        <div class="form-group">
                            <label for="optional_images">Optional Images</label>
                            <input type="file" id="optional_images" accept=".jpeg , .png  , .jpg" multiple>
                        </div>
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <select name="category_id" id="category_name"></select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" id="add-product-send" link="<?= ROOT ?>ajax/products/add">Add Product</button>
                            <button type="button" class="btn btn-danger" id="close">Close</button>
                        </div>
                    </form>
                </div>
                <div class="edit_product hide">
                    <form class="form-inline">
                        <div class="form-group mb-2">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" name="name" class="form-control-plaintext" id="productName">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2" link="<?= ROOT ?>ajax/products/edit_info">Edit Product</button>
                    </form>
                </div>
                <button class="btn btn-primary add-product-btn" style="margin: 20px 0;" onclick="addProduct()"><i class="fa fa-plus"></i> Add new Product</button>
            </div>
        </div>
        <?php $this->view("admin/footer") ?>
        <script>
            // Add Div
            let btn = document.querySelector(".add-product-btn");
            btn
            let close = document.querySelector("#add-product-btn");
            $(".add-product-btn").on("click", () => {
                $(".add-product").css('display', 'block')
            })
            $("#close").on("click", () => {
                $(".add-product").css("display", 'none')
            })

            // Edit Div Information
        </script>
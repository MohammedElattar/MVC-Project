<?php $this->view("admin/header", $data); ?>
<style>
    .add-category {
        background-color: #EEE;
        width: 400px;
        height: 300px;
    }
</style>
<?php $this->view("admin/sidebar") ?>
<h3><i class="fa fa-angle-right"></i> Categories</h3>
<div class="row mt">
    <div class="col-lg-12">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <table class="table table-striped table-advance table-hover table-responsive">
                        <h4><i class="fa fa-angle-right"></i> All Categories</h4>
                        <hr>
                        <thead>
                            <tr>
                                <th><i class="fa fa-bullhorn"></i> Name</th>
                                <th><i class="fa fa-bullhorn"></i>Sub Category</th>
                                <th class="text-center"><i class="fa fa-edit"></i> Status</th>
                                <th class="text-center">Control</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            <?= $data['data'] ?>
                        </tbody>
                    </table>
                </div><!-- /content-panel -->
                <div class="add-category" style="display: none;">
                    <form action="<?= ROOT ?>ajax/categories/add" method="POST" class="add-category-form">
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input type="text" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="name">Sub Category</label>
                            <select name="sub_category" id="sub_category" link="<?= ROOT ?>ajax/categories/add/get_sub_categories"></select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" id="add-category-send">Add Category</button>
                            <button type="button" class="btn btn-danger" id="close">Close</button>
                        </div>
                    </form>
                </div>
                <div class="edit_category hide">
                    <form class="form-inline">
                        <div class="form-group mb-2">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" name="name" class="form-control-plaintext" id="categoryName">
                        </div>
                        <div class="form-group">
                            <label for="name">Sub Category</label>
                            <select name="sub_category" id="edit_sub_category" link="<?= ROOT ?>ajax/categories/edit/get_content"></select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Edit Category</button>
                    </form>
                </div>
                <button class="btn btn-primary add-category-btn" style="margin: 20px 0;" onclick="addCategory()"><i class="fa fa-plus"></i> Add new Category</button>
            </div>
        </div>
        <?php $this->view("admin/footer") ?>
        <script>
            // Add Div
            let btn = document.querySelector(".add-category-btn");
            btn
            let close = document.querySelector("#add-category-btn");
            $(".add-category-btn").on("click", () => {
                $(".add-category").css('display', 'block')
            })
            $("#close").on("click", () => {
                $(".add-category").css("display", 'none')
            })

            // Edit Div Information
        </script>
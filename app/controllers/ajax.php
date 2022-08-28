<?php
class Ajax extends Controller
{
    public function index()
    {
        header("Location:" . ROOT);
    }
    public function home($params)
    {
        $params = json_decode($params, true);
        if ($this->logged()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $res = [];
                if (isset($params[2]) && $params[2] == 'get_products') {
                    $product = $this->load_model("Product");
                    $data = $product->show();
                    $str = '';
                    foreach ($data as $i) {
                        $str .= sprintf('<div class="col-sm-4">
						<div class="product-image-wrapper">
							<div class="single-products">
								<div class="productinfo text-center" onclick="location.href.replace(%s)">
									<img src = %s alt="Product" onclick="getSingleProduct(event)" />
									<h2 onclick="getSingleProduct(event)">%s</h2>
									<p>%s</p>
									<a href="#" class="btn btn-default add-to-cart" data-id=%s><i class="fa fa-shopping-cart"></i>Add to cart</a>
								</div>
							</div>
							<div class="choose">
								<ul class="nav nav-pills nav-justified">
									<li><a href="#"><i class="fa fa-plus-square" data-id=%s></i>Add to wishlist</a></li>
									<li><a href="#"><i class="fa fa-plus-square" data-id=%s></i>Add to compare</a></li>
								</ul>
							</div>
						</div>
					</div>', ROOT . "product_details/home/slag=" . $i['id'], "../public/uploads/" . $i['main_image'], $i['name'], $i['description'], $i['id'], $i['id'], $i['id']);

                    }
                    $res = $str;
                }
                if ($res) {
                    $res = json_encode($res);
                    echo $res;
                }
            }
            else
                header("Location:" . ROOT);
        }
        else
            header("Location:" . ROOT . "login");
    }
    public function categories($params = "")
    {
        if ($this->logged()) {
            $params = json_decode($params, true);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $res = [];
                $category = $this->load_model("Category");
                $_POST = json_decode(file_get_contents('php://input'), true);
                if (isset($params[2]) && $params[2] == 'add') {

                    if (!isset($params[3]))

                        $res = json_encode($category->add($_POST));
                    else {

                        if ($params[3] == 'get_sub_categories') {

                            $str = "<option value='0'>Main Category</option>";

                            foreach ($category->show("SELECT id , name FROM categories WHERE disabled = 0", [], 1) as $i) {
                                $str .= sprintf("<option value='%s'>%s</option>", $i['id'], $i['name']);
                            }

                            $res = $str;
                        }
                    }
                }
                else if (isset($params[2]) && $params[2] == 'edit_status') {
                    $res = json_encode($category->edit_status($_POST));
                }
                else if (isset($params[2]) && $params[2] == 'edit_name') {
                    $res = json_encode($category->edit_name($_POST));
                }
                else if (isset($params[2]) && $params[2] == 'get_content') {

                    $data = $category->show("SELECT name , id,  sub_category_of FROM categories WHERE id =?", [$_POST['id']], true)[0];
                    $res['name'] = $data['name'];
                    $res['sub_category'] = sprintf("<option value='0' %s>Main Category</option>", $data['sub_category_of'] == 0 ? 'selected' : '');
                    foreach ($category->show("SELECT name , id , sub_category_of FROM categories WHERE disabled=0 AND id != ? ", [$data['id']], true) as $i) {
                        $res['sub_category'] .= sprintf("<option value='%s' %s>%s</option>", $i['id'], $i['id'] == $data['sub_category_of'] ? "selected" : "", $i['name']);
                    }
                    $res = json_encode($res);
                }
                else if (isset($params[2]) && $params[2] == 'get_contents_for_products') {
                    $str = '';
                    foreach ($category->show("SELECT id , name FROM categories WHERE disabled=0", [], true) as $i) {
                        $str .= sprintf('
                        <option value="%s">%s</option>
                        ', $i['id'], $i['name']);
                    }
                    $res = $str;
                    $res = json_encode($res);
                }
                else if (isset($params[2]) && $params[2] == 'delete') {
                    $category->delete($_POST);
                }
                else
                    header("Location:" . ROOT . "admin/categories");
                if ($res)
                    echo $res;
            }
        }
        else
            header("Location:" . ROOT);
    }

    public function products($params = "")
    {

        if ($this->logged()) {
            $params = json_decode($params, true);
            if ($this->isPost()) {

                $res = [];
                $product = $this->load_model("Product");
                // ! Remove that line because it cause a bug when we send files to PHP 
                // $_POST = json_decode(file_get_contents('php://input'), true);
                if (isset($params[2]) && $params[2] == 'add') {
                    $res = json_encode($product->add($_POST, $_FILES));
                }
                else if (isset($params[2]) && $params[2] == 'edit_status') {
                    $res = json_encode($product->editStatus($_POST));
                }
                else if (isset($params[2]) && $params[2] == 'edit_info') {
                    if (isset($params[3]) && $params[3] == 'get_contents') {
                        $_POST = json_decode(file_get_contents('php://input'), true);
                        $id = $_POST['id'];
                        $category = $this->load_model("Category");
                        $product_info = $product->show("SELECT id , name , description , quantity , price , category_id FROM products WHERE id =?", [$id]);
                        $cats = '';
                        foreach ($category->show("SELECT * FROM CATEGORIES", [], true) as $i) {
                            $cats .= sprintf('<option value="%s" %s>%s</option>', $i['id'], $i['id'] == $product_info['category_id'] ? "selected" : "", $i['name']);
                        }
                        for ($i = 0; $i < 6; $i++)
                            unset($product_info[$i]);
                        unset($product_info['id']);
                        $product_info['category_id'] = $cats;
                        $res = $product_info;
                        $res = json_encode($res);
                    }
                    else {
                        $res = json_encode($product->editInfo($_POST));
                    }
                }
                else if (isset($params[2]) && $params[2] == 'edit_images') {
                }
                else if (isset($params[2]) && $params[2] == 'delete') {
                    $product->delete(json_decode(file_get_contents('php://input'), true));
                }
                else if (isset($params[2]) && $params[2] == 'get_content') {
                    $content = $product->get_content($_POST);
                    $str = '';
                    foreach ($content as $i) {
                        $str .= sprintf(
                            '<tr node-%s>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td class="text-center">
                                    <a href="%sajax/products/edit_info" class="btn btn-primary btn-xs edit" data-id="%s" onclick="editProductInfo(event)"><i class="fa fa-edit"></i></a>
                                    <a href="%sajax/products/delete" class="btn btn-danger btn-xs delete" data-id="%s" onclick="deleteProduct(event)"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>
                    ',
                            $i['name'],
                            $i['quantity'],
                            $i['price'],
                            $i['main_image'],
                            $i['cat_name'],
                            sprintf(
                            "<a href='%s' class='btn %s status' data-id='%s' onclick='editProductStatus(event)'>%s</a>",

                            ROOT . "ajax/categories/edit_status",
                            $i['status'] == 0 ? "btn-primary" : ($i['status'] == 1 ? "btn-success" : "btn-danger"),
                            $i['id'],
                            $i['status'] == 0 ? "Normal" : ($i['status'] == 1 ? "Sale" : "New"),
                            ROOT,
                            $i['id'],
                            ROOT,
                            $i['id']
                        ),
                        );
                    }
                    $res['data'] = $str;
                    $res = json_encode($res);
                }
                else
                    header("Location:" . ROOT . "admin/products");
                if ($res)
                    echo $res;
            }
            else
                header("Location:" . ROOT);
        }
        else
            header("Location:" . ROOT);
    }
}
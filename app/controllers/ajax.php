<?php
class Ajax extends Controller
{
    public function index()
    {
        header("Location:" . ROOT);
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
                    $res = json_encode($product->editInfo($_POST));
                }
                else if (isset($params[2]) && $params[2] == 'delete') {
                    $product->delete($_POST);
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
                                    <a href="%sajax/products/edit_info" class="btn btn-primary btn-xs edit" id="%s" onclick="editProductInfo(event)"><i class="fa fa-edit"></i></a>
                                    <a href="%sajax/products/delete" class="btn btn-danger btn-xs delete" id="%s" onclick="deleteProduct(event)"><i class="fa fa-trash-o "></i></a>
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

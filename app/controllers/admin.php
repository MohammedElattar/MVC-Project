<?php
class Admin extends Controller
{

    public function index()
    {
        if ($this->logged()) {
            if ($_SESSION['data']['rank'] == 'admin') {
                $data['title'] = "Admin";
                $this->view("admin/blank", $data);
            } else {
                header("Location:" . ROOT);
            }
        } else header("Location:" . ROOT);
    }
    public function categories($param = "")
    {
        /**
         * Categories Function
         * 
         * This function is used to manage categories and all operations on it 
         * 
         * @param string $param The Operation to do on categories
         * 
         */

        if ($this->logged()) {
            $category = $this->load_model("Category");
            if ($param == 'home') {
                $data['title'] = 'Categories';
                $data['data'] = $category->show();
                $this->view("admin/categories", $data);
            } else header("Location:" . ROOT . "404");
        } else header("Location:" . ROOT);
    }

    public function products($param = "")
    {
        if ($this->logged()) {
            $product = $this->load_model("Product");
            // var_dump($product);
            if ($param == 'home') {
                $data['title'] = "Products";
                $str = '';
                foreach ($product->show() as $i) {
                    $str .= sprintf(
                        '<tr node-%s>
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
                        $i['id'],
                        $i['name'],
                        $i['quantity'],
                        $i['price'],
                        sprintf("<img src='%s' style='width:100px;height:50px'>", ROOT . "uploads/" . $i['main_image']),
                        $i['cat_name'],
                        sprintf(
                            "<a href='%s' class='btn %s status' data-id='%s' onclick='editProductStatus(event)'>%s</a>",

                            ROOT . "ajax/categories/edit_status",
                            $i['status'] == 0 ? "btn-primary" : ($i['status'] == 1 ? "btn-success" : "btn-danger"),
                            $i['id'],
                            $i['status'] == 0 ? "Normal" : ($i['status'] == 1 ? "Sale" : "New"),
                        ),
                        ROOT,
                        $i['id'],
                        ROOT,
                        $i['id']
                    );
                }
                $data['data'] = $str;
                $this->view("admin/products", $data);
            } else header("Location:" . ROOT . "admin/products");
        } else header("Location:" . ROOT);
    }
}

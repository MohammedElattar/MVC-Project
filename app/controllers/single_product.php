<?php
class single_product extends Controller
{

    public function index($params)
    {
        $user = $this->load_model("User");
        if ($user->loggedIn()) {
            $params = json_decode($params, true);

            if (is_array($params) && isset($params[2]) && isset($params[3])) {
                $slag = explode('=', $params[2]);
                $id = explode('=', $params[3]);
                if (is_array($slag) && isset($slag[1]) && is_array($id) && isset($id[1]) && is_numeric($id[1])) {
                    $product = $this->load_model("Product");
                    $res = $product->show("SELECT * FROM products WHERE id =?", [$id[1]], true, false);
                    $res['other_images'] = json_decode($res['other_images']);
                    $data['title'] = "Single Product";
                    $data['data'] = $res;
                    $this->view("eshop/single_product", $data);
                }
                else
                    header("Location:" . ROOT);
            }
            else
                header("Location:" . ROOT);
        }
        else {
            $data['title'] = 'Login';
            $this->view("eshop/login", $data);
        }
    }
}

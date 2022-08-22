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
    public function categories($param = [])
    {
        if ($this->logged()) {
            $category = $this->load_model("Category");
            if ($param == 'home') {
                $data['title'] = 'Categories';
                $data['data'] = $category->show();
                $this->view("admin/categories", $data);
            }
        } else header("Location:https://www.amazon.com");
    }
}

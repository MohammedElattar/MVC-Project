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
            echo "Hi From Products";
        } else header("Location:" . ROOT);
    }
}

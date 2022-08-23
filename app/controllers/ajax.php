<?php
class Ajax extends Controller
{
    public function index()
    {
    }
    public function categories($param)
    {
        if ($this->logged()) {
            $param = trim($param);
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $res = [];
                $category = $this->load_model("Category");
                $_POST = json_decode(file_get_contents('php://input'), true);
                if ($param == 'add') {
                    $res = json_encode($category->add($_POST));
                } else if ($param == 'edit_status') {
                    $res = json_encode($category->edit_status($_POST));
                } else if ($param == 'edit_name') {
                    $res = json_encode($category->edit_name($_POST));
                } else if ($param == 'get_content') {

                    $res = json_encode($category->show("SELECT name FROM categories WHERE id =?", [$_POST['id']])['name']);
                } else if ($param == 'delete') {
                    $category->delete($_POST);
                } else header("Location:" . ROOT . "admin/categories");
                if ($res) echo $res;
            }
        } else header("Location:" . ROOT);
    }
}

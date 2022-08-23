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

                $category = $this->load_model("Category");
                $_POST = json_decode(file_get_contents('php://input'), true);
                if ($param == 'add') {
                    $res = json_encode($category->add($_POST));
                    echo $res;
                } else if ($param == 'edit_status') {
                    $res = $category->edit_status($_POST);
                    $res = json_encode($res);
                    echo $res;
                } else if ($param == 'edit_name') {
                    // print_r($_POST);
                    // echo "Hi From Edit Status";
                    $res = json_encode($category->edit_name($_POST));
                    echo $res;
                } else if ($param == 'delete') {
                    $category->delete($_POST);
                }
            }
        } else header("Location:" . ROOT);
    }
}

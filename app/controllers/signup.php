<?php

class SignUp extends Controller
{
    public function index()
    {
        $user = $this->load_model("User");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = json_decode(file_get_contents('php://input'));
            $res = $user->SignUp($_POST);
            $res = json_encode($res);
            echo $res;
        }
        else {
            if ($user->loggedIn()) {
                header("Location:" . ROOT);
            }
            else {
                $data['title'] = 'Sign Up';
                $this->view("eshop/signup", $data);
            }
        }
    }
}

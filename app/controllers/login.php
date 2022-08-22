<?php
class Login extends Controller
{

    public function index()
    {
        $user = $this->load_model("User");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = json_decode(file_get_contents('php://input'));
            $res = $user->Login($_POST);
            if (isset($res['data'])) {
                $_SESSION['data'] = $res['data'];
                unset($res['data']);
            }
            $res = json_encode($res);
            echo $res;
        } else {
            if ($user->loggedIn()) {
                $data['title'] = 'Home';
                $this->view("eshop/index", $data);
            } else {
                $data['title'] = 'Login';
                $this->view("eshop/login", $data);
            }
        }
    }
}

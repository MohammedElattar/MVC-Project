<?php
class Home extends Controller
{

    public function index()
    {
        $user = $this->load_model("User");
        if ($user->loggedIn()) {
            $data['title'] = "Home";
            $this->view("eshop/index", $data);
        }
        else {
            $data['title'] = 'Login';
            $this->view("eshop/login", $data);
        }
    }
}

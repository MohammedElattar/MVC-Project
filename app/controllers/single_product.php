<?php
class single_product extends Controller
{

    public function index($params)
    {
        $user = $this->load_model("User");
        if ($user->loggedIn()) {
            $params = json_decode($params, true);
            $data['title'] = "Home";
            $this->view("eshop/index", $data);
        }
        else {
            $data['title'] = 'Login';
            $this->view("eshop/login", $data);
        }
    }
}

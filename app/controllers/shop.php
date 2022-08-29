<?php
class Shop extends Controller
{

    public function index()
    {
        $user = $this->load_model("User");
        if ($user->loggedIn()) {
            $data['title'] = "Shop";
            $this->view("eshop/shop", $data);
        }
        else {
            $data['title'] = 'Login';
            $this->view("eshop/login", $data);
        }
    }
}

<?php

class Profile extends Controller
{
    public function index()
    {
        $data['title'] = "Profile";
        $this->view("eshop/profile", $data);
        "this is {constant()}";
    }
}

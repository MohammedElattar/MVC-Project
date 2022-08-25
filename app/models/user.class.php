<?php

class User
{

    public function SignUp($POST)
    {
        /**
         * Sign Up User
         * 
         * This function used to add new user to database
         * 
         * @param array $POST Form Data
         * 
         * @return array $res results
         */

        $res = [];
        $name = htmlspecialchars($POST->name);
        $email = htmlspecialchars($POST->email);
        $pass = htmlspecialchars($POST->pass);
        $db = db::get_instance();
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL))
            $res['valid-email'] = '1';
        if (!$name || preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $name) || is_numeric($name))
            $res['valid-name'] = '1';
        if (strlen($pass) < 4)
            $res['pass'] = '1';
        if (!$res) {
            $found = $db->read("SELECT email FROM users WHERE email=?", [$email]);
            if ($found[0])
                $res['exists'] = '1';
            else {
                $db->write("INSERT INTO users (Name , email , password , date , rank) VALUES(?,?,?,?,?)", [$name, $email, sha1($pass), date("Y-m-d H:i:s"), "customer"]);
                $res['success'] = '1';
            }
        }
        return $res;
    }
    public function Login($POST, $returnData = true)
    {
        /**
         * Login User
         * This function used to authenticate the user to access the website
         * 
         * @param array $POST Form Data
         * 
         * @return array $res results
         */
        $res = [];
        $email = htmlspecialchars($POST->email);
        $pass = htmlspecialchars($POST->pass);
        $db = db::get_instance();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $res['email'] = '1';
        if (strlen($pass) < 4)
            $res['pass'] = '1';
        if (!$res) {
            $found = $db->read("SELECT id , name , rank , email FROM users WHERE email=? AND password=? LIMIT 1", [$email, sha1($pass)], true);
            if ($found[1]) {
                $res['success'] = '1';
                if ($returnData)
                    $res['data'] = $found[0][0];
            }
            else {
                $res['not-exists'] = '1';
            }
        }
        return $res;
    }

    public function loggedIn()
    {
        return isset($_SESSION['data']['id']);
    }
}

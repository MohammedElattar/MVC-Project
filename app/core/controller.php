<?php


class Controller

{
    /**
     * Controller
     *
     * @author  Mohamed Attar
     */

    public function view($path, $data = [])
    {
        /**
         * View The UI Content
         * 
         * returns a UI Content
         * 
         * @param string $path The path of the file
         * 
         * @param Array $data  data you want to pass to show for example Title Of The Page
         */
        if (file_exists("../app/views/$path.php")) {
            include "../app/views/$path.php";
        } else include "../app/views/eshop/404.php";
    }
    public function load_model($model_name)
    {
        /**
         * Load Models
         * 
         * returns An Class Object Of Desired Model
         * 
         * @param string $model_name The Model You Want To Call.
         *
         * @return string Returns The File Name of desired model
         */

        if (file_exists("../app/models/" . strtolower($model_name) . ".class.php")) {
            include "../app/models/" . strtolower($model_name) . ".class.php";
            return new $model_name();
        }
    }
    public function logged()
    {
        $user = $this->load_model("User");
        return $user->loggedIn();
    }
}

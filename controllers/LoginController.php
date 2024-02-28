<?php 

require_once 'models/User.php';
require_once 'models/UserManager.php';

class LoginController {

    public function __construct()
    {

        // Si on est dans une requête post, alors on lance la méthode addRoom(). 
        if (!empty($_POST) && isset($_POST['email'])) {
            $this->loginUser();
        }
    }

    public function display() {
        $template = "login.phtml";
        require_once "views/layout.phtml";
    }


    public function loginUser()
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $manager = new UserManager();
        $manager->loginUser($email, $password);
    }
}
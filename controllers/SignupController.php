<?php 

require_once 'models/User.php';
require_once 'models/UserManager.php';

class SignupController {

    public function __construct()
    {

        // Si on est dans une requête post, alors on lance la méthode addRoom(). 
        if (!empty($_POST) && isset($_POST['name'])) {
            $this->addUser();
            header('Location: http://localhost/cup_of_tea_php/login');
            exit;
        }
    }

    public function display() {
        $template = "signup.phtml";
        require_once "views/layout.phtml";
    }


    
    // Ajout d'un salon
    public function addUser()
    {
        $last_name = ucfirst(trim($_POST['last_name']));
        $name = ucfirst(trim($_POST['name']));
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // var_dump($name, $last_name, $email, $password);

        $manager = new UserManager();

        $manager->addUser($last_name, $name, $email, $password);
    }

}
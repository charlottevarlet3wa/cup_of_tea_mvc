<?php 

require_once 'models/User.php';
require_once 'models/UserManager.php';

class SignupController {

    public function __construct()
    {
        if (!empty($_POST) && isset($_POST['email'])) {
            $this->addUser();
        } 
    }

    public function display() {
        $message = $_SESSION['message'] ?? '';
        unset($_SESSION['message']);
        $template = "signup.phtml";
        require_once "views/layout.phtml";
    }


    public function addUser() {
        if (isset($_POST['last_name'], $_POST['name'], $_POST['email'], $_POST['password']) &&
            !empty($_POST['last_name']) && !empty($_POST['name']) && 
            !empty($_POST['email']) && !empty($_POST['password'])) {
    
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['message'] = "Format de l'email invalide.";
                header("Location: signup");
                exit;
            }
    
            $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&]{8,}$/';
            if (!preg_match($passwordRegex, $_POST['password'])) {
                $_SESSION['message'] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                header("Location: signup");
                exit;
            }
    
            $lastName = htmlspecialchars(ucfirst(trim($_POST['last_name'])));
            $name = htmlspecialchars(ucfirst(trim($_POST['name'])));
            $email = htmlspecialchars(trim($_POST['email']));
            $password = htmlspecialchars(trim($_POST['password']));
    
            $manager = new UserManager();
            $result = $manager->addUser($lastName, $name, $email, $password);
    
            if ($result) {
                header('Location: login');
                exit;
            } else {
                $_SESSION['message'] = "Cette adresse e-mail est déjà utilisée.";
                header("Location: signup");
                exit;
            }
        } else {
            $_SESSION['message'] = "Tous les champs sont obligatoires";
            header("Location: signup");
            exit;
        }
    }
    

}
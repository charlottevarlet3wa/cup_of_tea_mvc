<?php 

// session_start(); // Start session at the top

require_once 'models/User.php';
require_once 'models/UserManager.php';

class SignupController {

    public function __construct() {
        if (!empty($_POST) && isset($_POST['email'])) {
            $this->addUser();
        } 
    }

    public function display() {
        $formData = $_SESSION['formData'] ?? [];
        $message = $_SESSION['message'] ?? '';
        unset($_SESSION['formData'], $_SESSION['message']);

        $template = "signup.phtml";
        require_once "views/layout.phtml";
    }

    public function addUser() {
        $_SESSION['formData'] = $_POST;

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "Format de l'email invalide.";
            header("Location: signup");
            exit;
        }
        
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_+^#])[A-Za-z\d@$!%*?&+_^#]{8,}$/';
        if (!preg_match($passwordRegex, $_POST['password'])) {
            $_SESSION['message'] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
            header("Location: signup");
            exit;
        }

        $manager = new UserManager();
        if (!$manager->addUser($_POST['last_name'], $_POST['name'], $_POST['email'], $_POST['password'])) {
            $_SESSION['message'] = "Cette adresse e-mail est déjà utilisée.";
            header("Location: signup");
            exit;
        }

        header('Location: login');
        exit;
    }
}

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
        $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        unset($_SESSION['error_message']);
        $template = "signup.phtml";
        require_once "views/layout.phtml";
    }


    public function addUser() {
        if (isset($_POST['last_name'], $_POST['name'], $_POST['email'], $_POST['password']) &&
            !empty($_POST['last_name']) && !empty($_POST['name']) && 
            !empty($_POST['email']) && !empty($_POST['password'])) {
    
            // Validate email format
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = "Format de l'email invalide.";
                header("Location: /cup_of_tea_php/signup");
                exit;
            }
    
            // Validate password strength
            $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&]{8,}$/';
            if (!preg_match($passwordRegex, $_POST['password'])) {
                $_SESSION['error_message'] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                header("Location: /cup_of_tea_php/signup");
                exit;
            }
    
            // Sanitize and trim input
            $lastName = htmlspecialchars(ucfirst(trim($_POST['last_name'])));
            $name = htmlspecialchars(ucfirst(trim($_POST['name'])));
            $email = htmlspecialchars(trim($_POST['email']));
            $password = htmlspecialchars(trim($_POST['password']));
    
            $manager = new UserManager();
    
            // Add the user
            $result = $manager->addUser($lastName, $name, $email, $password);
    
            if ($result) {
                // Redirect on success
                header('Location: http://localhost/cup_of_tea_php/login');
                exit;
            } else {
                // Handle failure, e.g., email already exists
                $_SESSION['error_message'] = "Cette adresse e-mail est déjà utilisée.";
                header("Location: /cup_of_tea_php/signup");
                exit;
            }
        } else {
            // Not all fields were filled in
            $_SESSION['error_message'] = "Tous les champs sont obligatoires";
            header("Location: /cup_of_tea_php/signup");
            exit;
        }
    }
    

}
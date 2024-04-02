<?php 

require_once 'models/User.php';
require_once 'models/UserManager.php';

class LoginController {

    public function __construct()
    {
        if (!empty($_POST) && isset($_POST['email'])) {
            $this->loginUser();
        }
    }

    public function display() {
        $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        unset($_SESSION['error_message']);
        $template = "login.phtml";
        require_once "views/layout.phtml";
    }


    public function loginUser()
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $manager = new UserManager();
        $user = $manager->loginUser($email, $password);

        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['admin'];
            session_regenerate_id();
            header("Location: my-account");
            exit;
        } else {
            // Login failed
            $_SESSION['error_message'] = "L'email et le mot de passe ne correspondent pas.";
            header("Location: login");
            exit;        
        }
    }
}
<?php 

require_once 'models/User.php';
require_once 'models/UserManager.php';

class LoginController {

    public function __construct()
    {
        if (!empty($_POST) && isset($_POST['email'])) {
            $this->login();
        }
    }

    public function display() {
        if(isset($_SESSION['user_id'])){
            header('Location: my-account');
            exit;
        }
        $message = $_SESSION['message'] ?? '';
        unset($_SESSION['message']);
        $template = "login.phtml";
        require_once "views/layout.phtml";
    }


    function login()
    {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['message'] = "Veuillez remplir tous les champs.";
            header("Location: login");
            exit;
        }

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
            $_SESSION['message'] = "L'email et le mot de passe ne correspondent pas.";
            header("Location: login");
            exit;        
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['is_admin']);
        session_regenerate_id(true);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
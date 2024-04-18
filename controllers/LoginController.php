<?php 

require_once 'models/User.php';
require_once 'models/UserManager.php';

class LoginController {

    public function __construct() {
        if (!empty($_POST) && isset($_POST['email'], $_POST['password'])) {
            $this->login();
        }
    }

    public function display() {
        if (isset($_SESSION['user_id'])) {
            header('Location: my-account');
            exit;
        }
        $email = $_SESSION['form_data']['email'] ?? '';
        $message = $_SESSION['message'] ?? '';
        unset($_SESSION['message'], $_SESSION['form_data']);
        $template = "login.phtml";
        require_once "views/layout.phtml";
    }

    function login() {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {
            $_SESSION['message'] = "Veuillez remplir tous les champs.";
            $_SESSION['form_data']['email'] = $email;
            header("Location: login");
            exit;
        }

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
            $_SESSION['form_data']['email'] = $email;
            header("Location: login");
            exit;        
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['is_admin']);
        session_regenerate_id(true);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

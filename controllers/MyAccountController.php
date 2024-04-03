<?php 

require_once 'models/User.php';
require_once 'models/UserManager.php';
require_once 'models/Order.php';
require_once 'models/OrderManager.php';

class MyAccountController {
    public function __construct()
    {
        if (!empty($_POST)) {
            if(isset($_POST['last-name'])){
                $this->changeUserInfo();
            }

        }
    }


    public function display() {
        if(!isset($_SESSION['user_id'])){
            header('Location: login');
            exit;
        }
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if($userId){
            $userManager = new UserManager();
            $user = $userManager->getUserById($userId);
            $orderManager = new OrderManager();
            $orders = $orderManager->getOrderByUser($userId);
        }
        $message = $_SESSION['message'] ?? '';
        unset($_SESSION['message']);
        $template = "myAccount.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }

    public function showDetail(){
        $orderId = $_POST['orderId'];
        
        $manager = new OrderManager();
        $details = $manager->getOrderDetailsById($orderId);
        $detailHtml = "";
        
        $detailHtml .= "<h3>Commande n° " . $orderId . "</h3>";

        foreach($details as $detail){
            $detailHtml .= "<p>" . $detail['name'] . " - " . $detail['cond'] . " - " . number_format($detail['price'], 2) . " €</p>";
        }
        echo $detailHtml;
    }
    public function changeUserInfo()
    {
        $id = $_SESSION['user_id'];
        $lastName = ucfirst(trim($_POST['last-name']));
        $name = ucfirst(trim($_POST['name']));
        $email = trim($_POST['email']);
        $oldPassword = trim($_POST['old-password']);
        $newPassword = trim($_POST['new-password']);
        $message = "";
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Le format de l'email est invalide.";
        }
        
        $manager = new UserManager();
        $user = $manager->getUserById($_SESSION['user_id']);
    
        if (empty($lastName) || empty($name) || empty($email)) {
            $message = "Le nom, le prénom et l'email sont obligatoires.";
        }
    
        if (empty($message)) {
            $updateInfo = $manager->updateUserInfo($id, $lastName, $name, $email);

            if(!empty($oldPassword)){
                if (!password_verify($oldPassword, $user['password'])) {
                    $message = "L'ancien mot de passe ne correspond pas.";
                }
            }
    
            if (!empty($oldPassword) && !empty($newPassword)) {
                if (!password_verify($oldPassword, $user['password'])) {
                    $message = "L'ancien mot de passe ne correspond pas.";
                } else {
                    $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]{8,}$/";
                    if (!preg_match($passwordRegex, $newPassword)) {
                        $message = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                    } else {
                        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 10]);
                        $updatePassword = $manager->updatePassword($id, $passwordHash);
                    }
                }
            }
    
            if (empty($message)) {
                $_SESSION['message'] = "Les informations ont été mises à jour.";
                header('Location: my-account');
                exit;
            }
        }
    
        $_SESSION['message'] = $message;
        header('Location: my-account');
        exit;
    }
    
}
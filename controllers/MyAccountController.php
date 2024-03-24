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
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if($userId){
            $userManager = new UserManager();
            $user = $userManager->getUserById($userId);
            $orderManager = new OrderManager();
            $orders = $orderManager->getOrderByUser($userId);
        }
        $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        unset($_SESSION['error_message']);
        $successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        unset($_SESSION['success_message']);
        $template = "myAccount.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }

    public function showDetail($orderId){
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
        $errorMessage = "";

        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Le format de l'email est invalide.";
        }
        
        // Validate password strength
        $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]{8,}$/";
        if (!empty($newPassword) && !preg_match($passwordRegex, $newPassword)) {
            $errorMessage = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }
        
        $manager = new UserManager();
        // Check old password match
        $user = $manager->getUserById($_SESSION['user_id']);
        if (!empty($oldPassword) && !password_verify($oldPassword, $user['password'])) {
            $errorMessage = "L'ancien mot de passe ne correspond pas.";
        }
        
        if (empty($lastName) || empty($name) || empty($email)) {
            $errorMessage = "Le nom, le prénom et l'email sont obligatoires.";
        }

        // If there are no errors, proceed with updating user information
        if (empty($errorMessage)) {
            $updateInfo = $manager->updateUserInfo($user['id'], $lastName, $name, $email);
            $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 10]);

            $updatePassword = $manager->updatePassword($user['id'], $passwordHash);

            if ($updateInfo && $updatePassword) {
                $_SESSION['success_message'] = "Les informations ont été mises à jour.";
                header('Location: /cup_of_tea_php/my-account');
                exit;
            } else {
                // Handle update failure
                $errorMessage = "Erreur lors de la mise à jour des informations.";
            }
        }

        // If there was an error, redirect back with an error message
        $_SESSION['error_message'] = $errorMessage;
        header('Location: /cup_of_tea_php/my-account');
        exit;
    }

}
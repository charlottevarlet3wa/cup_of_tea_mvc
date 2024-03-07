<?php 

require_once 'models/User.php';
require_once 'models/UserManager.php';
require_once 'models/Order.php';
require_once 'models/OrderManager.php';

class MyAccountController {
    public function display() {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if($userId){
            $userManager = new UserManager();
            $user = $userManager->getUserById($userId);
            $orderManager = new OrderManager();
            $orders = $orderManager->getOrderByUser($userId);
        }
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
}
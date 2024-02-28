<?php 

require_once 'models/Order.php';
require_once 'models/OrderManager.php';

class AdminController {    
    
    public function __construct()
    {

        // Si on est dans une requête post, alors on lance la méthode addRoom(). 
        if (!empty($_POST) && isset($_POST['orderId'])) {
            $this->updateStatus($_POST['orderId'], $_POST['status']);
        }
    }


    public function display() {
        $manager = new OrderManager();
        $orders = $manager->getAllOrders();

        $template = "admin.phtml";
        require_once "views/layout.phtml";
    }


    public function updateStatus($orderId, $status){
        $manager = new OrderManager();
        // $status = $manager
    }
}
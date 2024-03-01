<?php 

require_once 'models/Order.php';
require_once 'models/OrderManager.php';

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

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
        
        $teaManager = new TeaManager();
        $teas = $teaManager->getAllTeas();
        $cats = $teaManager->getAllCategories();

        $template = "admin.phtml";
        require_once "views/layout.phtml";
    }


    public function updateStatus($orderId, $status){
        $manager = new OrderManager();
        // $status = $manager
    }

    /* ADD TEA */

    // public function addTea($ref, $cat, $name, $subtitle, $description, $image, $isFavorite) {
    public function addTea($ref, $name) {
        // $tea = new Tea();
        // $tea->ref = $_POST['ref'];
        // $tea->categoryId = $_POST['cat'];
        // $tea->name = $_POST['name'];
        // $tea->subtitle = $_POST['subtitle'];
        // $tea->description = $_POST['description'];
        // $tea->image = $_FILES['photo']['name'];
        // $tea->isFavorite = isset($_POST['favorite']);

        $teaManager = new TeaManager();
        // $teaManager->addTea($ref, $cat, $name, $subtitle, $description, $image, $isFavorite);
        $teaManager->addTea($ref, $name);

        // Redirect or display a success message

    }
}
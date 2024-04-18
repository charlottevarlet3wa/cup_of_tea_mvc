<?php 

require_once 'models/Order.php';
require_once 'models/OrderManager.php';

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

require_once 'models/User.php';
require_once 'models/UserManager.php';

require_once 'models/Order.php';
require_once 'models/OrderManager.php';


class AdminController {    


    public function display() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit;
        }

        $userManager = new UserManager();
        $user = $userManager->getUserById($_SESSION['user_id']);
    
        if (!$user['admin']) {
            header('Location: home');
            exit;
        }
    
        $manager = new OrderManager();
        $orders = $manager->getAllOrders();
        
        $teaManager = new TeaManager();
        $teas = $teaManager->getAllTeas();
        $cats = $teaManager->getAllCategories();

        $template = "admin.phtml";
        require_once "views/layout.phtml";
    }

    
    public function addTea(){
        $ref = $_POST['ref'] ?? null;
        $name = $_POST['name'] ?? null;
        $subtitle = $_POST['subtitle'] ?? null;
        $description = $_POST['description'] ?? null;
        $cat = $_POST['cat'] ?? null;
        $stock = $_POST['stock'] ?? null;
        $isFavorite = $_POST['isFavorite'] ?? 0;
        
        if (empty($ref) || empty($name) || empty($subtitle) || empty($description) || empty($cat) || empty($stock) || !isset($_FILES['image'])) {
            echo "All fields are required.";
            return;
        }
        
        $formatPrices = $_POST['formatPrice'] ?? [];
        $formatConditionings = $_POST['formatConditioning'] ?? [];

        $formats = 0;
        for($i = 0; $i < count($formatPrices); $i++){
            if(!empty($formatPrices[$i] && !empty($formatConditionings[$i]))){
                $formats++;
            }
        }
        if($formats == 0){
            echo "Un format de thé est nécessaire au minimum.";
            return;
        }

        if (!(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK)) {
            echo "Choisir un fichier.";
            return;
        }

        if (isset($_FILES['image'])) {
            $imageName = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $targetDir = "public/img/product/";
            $targetFile = $targetDir . basename($imageName);
            $imagePath = "product/" . basename($imageName);

            // vérifier si le fichier est une image
            $check = getimagesize($imageTmpName);
            if($check !== false) {
                if (move_uploaded_file($imageTmpName, $targetFile)) {
                    $controller = new AdminController();
                    $message = $controller->addTea($ref, $name, $subtitle, $description, $imagePath, $cat, $stock, $isFavorite, $formatPrices, $formatConditionings);
                    if($message == "success") {
                        echo "Votre thé a été ajouté avec succès.";
                        return;
                    }
                    echo $message;

                } else {
                    echo "Une erreur est survenue lors du téléchargement de votre fichier.";
                }
            } else {
                echo "Le fichier n'est pas une image.";
            }
        } else {
            echo "Choisir un fichier.";
        }
    }

    public function addFormat($teaId, $price, $conditioning) {

        $teaManager = new TeaManager();
        $error = $teaManager->addFormat($teaId, $price, $conditioning);

        return $error;
    }


    
    public function updateStatus(){
        $orderId = $_POST['orderId'] ??  null;
        $filter = $_POST['filter'] ?? null;
        $manager = new OrderManager();
        $manager->updateStatus($orderId);
        $this->filterOrders($filter);
    }

    public function filterOrders(){
        $filter = $_POST['filter'] ?? null;
        $filteredOrdersHtml = '';
        
        $manager = new OrderManager();
        $orders = $manager->getAllOrders();
        
        foreach ($orders as $order) {
            $includeOrder = false;
            switch ($filter) {
                case 'all':
                    $includeOrder = true;
                    break;
                case 'processed':
                    if ($order['status'] == 1) {
                        $includeOrder = true;
                    }
                    break;
                case 'unprocessed':
                    if ($order['status'] == 0) {
                        $includeOrder = true;
                    }
                    break;
            }
            if ($includeOrder) {
                $filteredOrders[] = $order;
            }
        }
        
        include "views/ajax/admin_filteredOrders.phtml";
    }

    public function showDetails(){
        $orderId = $_POST['orderId'] ?? null;
        $manager = new OrderManager();
        $details = $manager->getOrderDetailsById($orderId);
        include "views/ajax/admin_orderDetails.phtml";
    }
    
        


}

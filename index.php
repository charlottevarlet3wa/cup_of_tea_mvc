<?php

declare(strict_types=1);

session_start();


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}



// Stripe
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

//charge les différents controllers
require_once 'controllers/AboutController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/CartController.php';
require_once 'controllers/CartComponentController.php';
require_once 'controllers/SignupController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/LoginController.php';
require_once 'controllers/MyAccountController.php';
require_once 'controllers/TeaController.php';
require_once 'controllers/TeasController.php';
require_once 'controllers/PaymentController.php';
require_once 'controllers/SuccessController.php';
require_once 'controllers/AddressController.php';

require_once 'controllers/TestController.php';

//vérifie si une route spécifique a été demandée, si non alors on charge la page home
if(!isset($_GET['route'])){
    $url = 'home';
}
else{
    $url = $_GET['route'];
}


//instancie le controller adéquate et lance l'affichage de la page
switch($_GET['route']){
    case 'home':
        $controller = new HomeController();
        $controller->display();
        break;        
    case 'about':
        $controller = new AboutController();
        $controller->display();
        break; 
    case 'admin':
        if (!isset($_SESSION['user_id'])) {
            header('Location: about');
            exit;
        }
    
        $manager = new UserManager();
        $user = $manager->getUserById($_SESSION['user_id']);
    
        if ($user['admin']) {
            $controller = new AdminController();
            $controller->display();
        } else {
            header('Location: home');
            exit;
        }
        break;

    case 'cart':
        $controller = new CartController();
        $controller->display();
        break; 
    case 'signup':
        $controller = new SignupController();
        $controller->display();
        break;        
    case 'login':
        if(isset($_SESSION['user_id'])){
            header('Location: my-account');
            exit;
            break;
        }
        $controller = new LoginController();
        $controller->display();
        break; 
    case 'logout':
        unset($_SESSION['user_id']);
        unset($_SESSION['is_admin']);
        session_regenerate_id(true);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        break;       
    case 'my-account':
        if(!isset($_SESSION['user_id'])){
            header('Location: login');
            exit;
            break;
        }
        $controller = new MyAccountController();
        $controller->display();
        break; 
    case 'tea':
        $teaId = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new TeaController();
        $controller->display($teaId);
        break;
    case 'teas':
        $controller = new TeasController();
        $controller->display();
        break; 
    case 'payment':
        if(!isset($_SESSION['user_id'])){
            header('Location: login');
            exit;
            break;
        }
        $controller = new PaymentController();
        $controller->display();
        break; 
    case 'success':
        if(!isset($_SESSION['user_id'])){
            header('Location: login');
            exit;
            break;
        }
        $controller = new SuccessController();
        $controller->display();
        break; 
    case 'address':
        if(!isset($_SESSION['user_id'])){
            header('Location: login');
            exit;
            break;
        }
        $controller = new AddressController();
        $controller->display();
        break; 




    case 'order-status':
        $orderId = $_POST['orderId'] ??  null;
        $filter = $_POST['filter'] ?? null;
        $controller = new TestController();
        $controller->updateStatus($orderId, $filter);
        break;

    case 'order-filter':
        $filter = isset($_POST['filter']) ? $_POST['filter'] : null;
        $controller = new TestController();
        $controller->filterOrders($filter);
        break;

    case 'show-details':
        $orderId = isset($_POST['orderId']) ? $_POST['orderId'] : null;
        $controller = new TestController();
        $controller->showDetails($orderId);
        break;

    case 'add-tea':
        $ref = $_POST['ref'] ?? null;
        $name = $_POST['name'] ?? null;
        $subtitle = $_POST['subtitle'] ?? null;
        $description = $_POST['description'] ?? null;
        $cat = $_POST['cat'] ?? null;
        $stock = $_POST['stock'] ?? null;
        $isFavorite = $_POST['isFavorite'] ?? 0;
        
        if (empty($ref) || empty($name) || empty($subtitle) || empty($description) || empty($cat) || empty($stock) || !isset($_FILES['image'])) {
            echo "All fields are required.";
            break;
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
            break;
        }

        if (!(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK)) {
            echo "No file was uploaded.";
            break;
        }

        if (isset($_FILES['image'])) {
            $imageName = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $target_dir = "public/img/product/"; // Make sure this directory exists and is writable.
            $target_file = $target_dir . basename($imageName);
            $imagePath = "product/" . basename($imageName);

    
            // Check if image file is an actual image or fake image
            $check = getimagesize($imageTmpName);
            if($check !== false) {
                if (move_uploaded_file($imageTmpName, $target_file)) {
                    // File is valid and was successfully uploaded.
                    // Here, insert the image path along with other tea information into your database
                    $controller = new AdminController();
                    $message = $controller->addTea($ref, $name, $subtitle, $description, $imagePath, $cat, $stock, $isFavorite, $formatPrices, $formatConditionings);
                    if($message == "success") {
                        echo "Votre thé a été ajouté avec succès.";
                        break;
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
        break;
        
    
    // case 'add-tea':
    //     $ref = isset($_POST['ref']) ? $_POST['ref'] : null;
    //     $name = isset($_POST['name']) ? $_POST['name'] : null;
    //     $subtitle = isset($_POST['subtitle']) ? $_POST['subtitle'] : null;
    //     $description = isset($_POST['description']) ? $_POST['description'] : null;
    //     // $image = isset($_POST['image']) ? $_POST['image'] : null;
    //     $cat = isset($_POST['cat']) ? $_POST['cat'] : null;
    //     $isFavorite = isset($_POST['isFavorite']) ? $_POST['isFavorite'] : 0;
        
    //     // echo $ref . $name . $subtitle . $description . $cat . $isFavorite;

    //     if (isset($_FILES['image'])) {
    //         $imageName = $_FILES['image']['name'];
    //         $imageTmpName = $_FILES['image']['tmp_name'];
    //     }



    //     $controller = new AdminController();
    //     $controller->addTea($ref, $name, $subtitle, $description, $imageName, $cat, $isFavorite, $imageTmpName);
    //     break;

    case 'add-to-cart':
        $teaId = isset($_POST['teaId']) ? $_POST['teaId'] : null;
        $formatId = isset($_POST['formatId']) ? $_POST['formatId'] : null;
        $controller = new CartComponentController();
        $controller->addToCart($teaId, $formatId);
        break;

    case 'remove-from-cart':
        $teaId = isset($_POST['teaId']) ? $_POST['teaId'] : null;
        $formatId = isset($_POST['formatId']) ? $_POST['formatId'] : null;
        $controller = new CartComponentController();
        $controller->removeFromCart($teaId, $formatId);
        break;

    case 'change-cart-quantity':
        $teaId = isset($_POST['teaId']) ? $_POST['teaId'] : null;
        $formatId = isset($_POST['formatId']) ? $_POST['formatId'] : null;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
        $controller = new CartComponentController();
        $controller->changeCartQuantity($teaId, $formatId, $quantity);
        break;

    case 'display-cart':
        $controller = new CartController();
        $controller->displayCart();
        break;

    case 'display-cart-header':
        $controller = new CartComponentController();
        $response = [
            'total' => $controller->calculateTotal(),
            'count' => $controller->calculateCount()
        ];
        echo json_encode($response);
        break;

    case 'account-show-detail';
        $orderId = $_POST['orderId'];
        $controller = new MyAccountController();
        $controller->showDetail($orderId);
        break;

    case 'change-user-info':
        
        break;
    default:
        header('Location: home');
        exit;
        break;
}

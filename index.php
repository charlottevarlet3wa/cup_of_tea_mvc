<?php


declare(strict_types=1);

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


/*
require_once './services/routing.php'; 
require_once './configs/settings.php';

// Determine the requested page
$route = $_GET['route'] ?? DEFAULT_ROUTE;
$route = array_key_exists($route, AVAILABLE_ROUTES) ? $route : 'home';

// Create router
$router = new Router($route);

// Include controller
$router->autoloadController();

// Instanciate controller
$controllerInstance = $router->getController();

// Depending on the page, handle accordingly
// if ($page === 'toggle_pin') {
//     $controllerInstance->togglePin();
// } else {
    $controllerInstance->display();
// }
*/

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
require_once 'controllers/LogoutController.php';
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
            header('Location: http://localhost/cup_of_tea_php/home');
            exit;
        }
    
        $manager = new UserManager();
        $user = $manager->getUserById($_SESSION['user_id']);
    
        if ($user['admin']) {
            $controller = new AdminController();
            $controller->display();
        } else {
            header('Location: http://localhost/cup_of_tea_php/home');
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
            header('Location: http://localhost/cup_of_tea_php/my-account');
            exit;
            break;
        }
        $controller = new LoginController();
        $controller->display();
        break; 
    case 'logout':
        unset($_SESSION['user_id']);
        session_regenerate_id(true);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        break;       
    case 'my-account':
        if(!isset($_SESSION['user_id'])){
            header('Location: http://localhost/cup_of_tea_php/login');
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
            header('Location: http://localhost/cup_of_tea_php/login');
            exit;
            break;
        }
        $controller = new PaymentController();
        $controller->display();
        break; 
    case 'success':
        if(!isset($_SESSION['user_id'])){
            header('Location: http://localhost/cup_of_tea_php/login');
            exit;
            break;
        }
        $controller = new SuccessController();
        $controller->display();
        break; 
    case 'address':
        if(!isset($_SESSION['user_id'])){
            header('Location: http://localhost/cup_of_tea_php/login');
            exit;
            break;
        }
        $controller = new AddressController();
        $controller->display();
        break; 




    case 'order-status':
        $isStatus = isset($_POST['status']) ? $_POST['status'] : null;
        $orderId = isset($_POST['orderId']) ? $_POST['orderId'] : null;
        $controller = new TestController();
        $controller->updateStatus($orderId, $isStatus);
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
        $ref = isset($_POST['ref']) ? $_POST['ref'] : null;
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $subtitle = isset($_POST['subtitle']) ? $_POST['subtitle'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;
        $image = isset($_POST['image']) ? $_POST['image'] : null;
        $cat = isset($_POST['cat']) ? $_POST['cat'] : null;
        $isFavorite = isset($_POST['isFavorite']) ? $_POST['isFavorite'] : 0;
    
        if (isset($_FILES['image'])) {
            $imageName = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
        }

        $controller = new AdminController();
        $controller->addTea($ref, $name, $subtitle, $description, $imageName, $cat, $isFavorite, $imageTmpName);
        break;

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
        header('Location: http://localhost/cup_of_tea_php/home');
        exit;
        break;
}

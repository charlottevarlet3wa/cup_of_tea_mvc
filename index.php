<?php


//charge les différents controllers
require_once 'controllers/AboutController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/CartController.php';
require_once 'controllers/SignupController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/LoginController.php';
require_once 'controllers/LogoutController.php';
require_once 'controllers/MyAccountController.php';
require_once 'controllers/TeaController.php';
require_once 'controllers/TeasController.php';

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
        $controller = new AdminController();
        $controller->display();
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
        $controller = new LoginController();
        $controller->display();
        break; 
    case 'logout':
        $controller = new LogoutController();
        $controller->display();
        break;        
    case 'my-account':
        $controller = new MyAccountController();
        $controller->display();
        break; 
    case 'tea':
        // $controller = new TeaController();
        $teaId = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new TeaController();
        $controller->display($teaId);
        break;        
    case 'teas':
        $controller = new TeasController();
        $controller->display();
        break; 


    case 'order-status':
        $isStatus = isset($_POST['status']) ? $_POST['status'] : null;
        $orderId = isset($_POST['orderId']) ? $_POST['orderId'] : null;
        $controller = new TestController();
        $controller->setStatus($orderId, $isStatus);
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
}


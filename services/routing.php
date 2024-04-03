<?php

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
        $controller = new LoginController();
        $controller->logout();
        break;       
    case 'my-account':
        $controller = new MyAccountController();
        $controller->display();
        break; 
    case 'tea':
        $controller = new TeaController();
        $controller->display();
        break;
    case 'teas':
        $controller = new TeasController();
        $controller->display();
        break; 
    case 'payment':
        $controller = new PaymentController();
        $controller->display();
        break; 
    case 'success':
        $controller = new SuccessController();
        $controller->display();
        break; 
    case 'address':
        $controller = new AddressController();
        $controller->display();
        break; 



    case 'order-status':
        $controller = new AdminController();
        $controller->updateStatus();
        break;

    case 'order-filter':
        $controller = new AdminController();
        $controller->filterOrders();
        break;

    case 'show-details':
        $controller = new AdminController();
        $controller->showDetails();
        break;

    case 'add-tea':
        $controller = new AdminController();
        $controller->addTea();
        break;
        
    case 'add-to-cart':
        $controller = new CartComponentController();
        $controller->addToCart();
        break;

    case 'remove-from-cart':
        $controller = new CartComponentController();
        $controller->removeFromCart();
        break;

    case 'change-cart-quantity':
        $controller = new CartComponentController();
        $controller->changeCartQuantity();
        break;

    case 'display-cart':
        $controller = new CartController();
        $controller->displayCart();
        break;
    case 'display-cart-header':
        $controller = new CartComponentController();
        $controller->updateDisplayCartHeader();
        break;
    case 'account-show-detail';
        $orderId = $_POST['orderId'];
        $controller = new MyAccountController();
        $controller->showDetail($orderId);
        break;

    case 'change-user-info':
        // TODO : why empty ? 
        break;
    default:
        header('Location: home');
        exit;
        break;
}
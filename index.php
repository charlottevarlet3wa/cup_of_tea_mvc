<?php


//charge les différents controllers
require_once 'controllers/AboutController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/CartController.php';
require_once 'controllers/CreateAccountController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/LoginController.php';
require_once 'controllers/LogoutController.php';
require_once 'controllers/MyAccountController.php';
require_once 'controllers/TeaController.php';
require_once 'controllers/TeasController.php';

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
        break;        
    case 'about':
        $controller = new AboutController();
        break; 
    case 'admin':
        $controller = new AdminController();
        break;        
    case 'cart':
        $controller = new CartController();
        break; 
    case 'create-account':
        $controller = new CreateAccountController();
        break;        
    case 'login':
        $controller = new LoginController();
        break; 
    case 'logout':
        $controller = new LogoutController();
        break;        
    case 'my-account':
        $controller = new MyAccountController();
        break; 
    case 'tea':
        // $controller = new TeaController();
        $teaId = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new TeaController();
        $controller->display($teaId);
        break;        
    case 'teas':
        $controller = new TeasController();
        break; 
}

if (isset($controller)) {
    $controller->display();
}
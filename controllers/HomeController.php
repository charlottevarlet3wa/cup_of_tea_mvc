<?php 

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

require_once 'controllers/AbstractController.php';

class HomeController extends AbstractController {

    public function display() {
        $manager = new TeaManager();
        $favorite = $manager->getFavorite();
        $latest = $manager->getLatest();
        $bestseller = $manager->getBestseller();
        $template = "home.phtml";
        $cartHeader = "cartHeader.phtml";
        require_once "views/layout.phtml";
    }
}
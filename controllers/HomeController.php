<?php 

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

class HomeController {


    public function display() {
        $manager = new TeaManager();
        $favorite = $manager->getFavorite();
        $latest = $manager->getLatest();
        $bestseller = $manager->getBestseller();
        
        $template = "home.phtml";
        require_once "views/layout.phtml";
    }
}
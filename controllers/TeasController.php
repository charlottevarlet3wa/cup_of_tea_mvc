<?php 

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

require_once 'controllers/AbstractController.php';

class TeasController extends AbstractController {
    public function display() {
        $manager = new TeaManager();
        $teas = $manager->getAllTeas();
        $cats = $manager->getAllCategories();

        $template = "teas.phtml";
        $cartHeader = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }   
}
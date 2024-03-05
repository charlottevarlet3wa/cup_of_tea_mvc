<?php 

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

class TeasController {
    public function display() {
        $manager = new TeaManager();
        $teas = $manager->getAllTeas();
        $cats = $manager->getAllCategories();

        $template = "teas.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }
}
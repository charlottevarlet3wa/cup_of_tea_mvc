<?php 

require_once 'controllers/AbstractController.php';

class AboutController extends AbstractController{
    public function display() {
        $template = "about.phtml";
        $cartHeader = "views/cartComponent.phtml";
        require_once "views/layout.phtml";
    }
}
<?php 

class AboutController {
    public function display() {
        $template = "about.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }
}
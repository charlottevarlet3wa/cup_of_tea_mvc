<?php 

class CartController {
    public function display() {
        $template = "cart.phtml";
        require_once "views/layout.phtml";
    }
}
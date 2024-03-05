<?php 

class MyAccountController {
    public function display() {
        $template = "myAccount.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }
}
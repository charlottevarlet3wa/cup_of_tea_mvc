<?php 

class SuccessController {
    public function display() {
        $template = "success.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }
}
<?php 

class SuccessController {
    public function display() {
        if(!isset($_SESSION['user_id'])){
            header('Location: login');
            exit;
        }
        $template = "success.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }
}
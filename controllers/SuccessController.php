<?php 

require_once 'controllers/AbstractController.php';

class SuccessController extends AbstractController {
    public function display() {
        if(!isset($_SESSION['user_id'])){
            header('Location: login');
            exit;
        }
        $template = "success.phtml";
        $cartHeader = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }
}
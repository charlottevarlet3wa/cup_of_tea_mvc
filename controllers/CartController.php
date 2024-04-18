<?php 

class CartController {
    public function display() {
        $template = "cart.phtml";
        $cart = $_SESSION['cart'];    
        require_once "views/layout.phtml";
    }
    

    public function displayCart() {
        $cart = $_SESSION['cart'];
        
        if (empty($cart)) {
            echo "empty";
            return;
        }

        include "views/ajax/cart_ajax.phtml";
    }
    
}
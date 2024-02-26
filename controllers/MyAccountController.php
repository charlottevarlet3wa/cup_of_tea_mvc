<?php 

class MyAccountController {
    public function display() {
        $template = "myAccount.phtml";
        require_once "views/layout.phtml";
    }
}
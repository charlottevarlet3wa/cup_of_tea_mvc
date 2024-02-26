<?php 

class LoginController {
    public function display() {
        $template = "login.phtml";
        require_once "views/layout.phtml";
    }
}
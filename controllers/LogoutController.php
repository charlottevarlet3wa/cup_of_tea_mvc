<?php 

class LogoutController {
    public function display() {
        $template = "logout.phtml";
        require_once "views/layout.phtml";
    }
}
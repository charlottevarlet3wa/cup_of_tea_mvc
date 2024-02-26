<?php 

class HomeController {
    public function display() {
        $template = "home.phtml";
        require_once "views/layout.phtml";
    }
}
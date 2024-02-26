<?php 

class AdminController {
    public function display() {
        $template = "admin.phtml";
        require_once "views/layout.phtml";
    }
}
<?php 

class AboutController {
    public function display() {
        $template = "about.phtml";
        require_once "views/layout.phtml";
    }
}
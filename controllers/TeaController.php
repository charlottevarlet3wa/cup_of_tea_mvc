<?php 

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

class TeaController {
    public function display() {
        $teaId = isset($_GET['id']) ? $_GET['id'] : null;
        $manager = new TeaManager();
        $tea = $manager->getTeaById($teaId);
        $formats = $manager->getFormatsByTea($teaId);
        // $prices = 
        $template = "tea.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }

} 
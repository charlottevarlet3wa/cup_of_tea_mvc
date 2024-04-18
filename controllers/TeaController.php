<?php 

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

require_once 'controllers/AbstractController.php';

class TeaController extends AbstractController {
    public function display() {
        $teaId = isset($_GET['id']) ? $_GET['id'] : null;
        $manager = new TeaManager();
        $tea = $manager->getTeaById($teaId);
        $formats = $manager->getFormatsByTea($teaId);
        $template = "tea.phtml";
        $cartHeader = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }

} 
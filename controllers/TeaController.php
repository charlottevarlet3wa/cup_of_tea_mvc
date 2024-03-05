<?php 

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

class TeaController {
    public function display($teaId = null) {
        $manager = new TeaManager();
        $tea = $manager->getTeaById($teaId);
        $formats = $manager->getFormatsByTea($teaId);
        // $prices = 
        $template = "tea.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }

} 


// TODO : tester
// TODO : change route to get tea ID
/*
declare(strict_types=1);

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';
require_once 'ControllerInterface.php';

// class TeaController implements ControllerInterface
class TeaController
{
    private $tea;
    private $teaManager;
    private $format;
    private $price;

    public function __construct()
    {
        $this->teaManager = new TeaManager();
        // Assuming we get tea ID from a query parameter or a similar source
        $teaId = $_GET['id'] ?? null;

        if ($teaId) {
            $this->tea = $this->teaManager->getTeaById((int)$teaId);
            $this->format = $this->teaManager->getFormatsByTea((int)$teaId);
            // Calculate price or fetch additional details as required
            $this->price = $this->calculatePrice($this->format);
        }
    }

    public function display()
    {
        // Assuming $tea, $format, and $price are made available to the view
        $tea = $this->tea;
        $format = $this->format;
        $price = $this->price;
        require './views/tea.phtml';
    }

    private function calculatePrice(array $format): float
    {
        // Implement logic to calculate price based on formats
        // This is a placeholder implementation
        return 0.0;
    }
}
*/
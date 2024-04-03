<?php 

require_once 'models/Address.php';
require_once 'models/AddressManager.php';

class AddressController {

    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['street'], $_POST['postal-code'], $_POST['town'], $_POST['country'])) {
                header("Location: address");
                $this->processAddressForm();
            } else {
                $_SESSION['message'] = "Tous les champs sont requis.";
                header("Location: address");
                exit;
            }
        }
    }

    public function display() {
        $message = $_SESSION['message'] ?? '';
        unset($_SESSION['message']);

        $template = "address.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }

    private function processAddressForm() {
        $userId = $_SESSION['user_id'] ?? null; 

        $street = trim($_POST['street']);
        if (empty($street) || !preg_match('/^\d+\s+[\p{L}\s]+/u', $street)) {
            $_SESSION['message'] = 'Entrez un numéro et un nom de rue valide.';
            header("Location: address");
            exit;
        }

        $parts = explode(' ', $street, 2);
        $streetNumber = $parts[0];
        $streetName = $parts[1] ?? '';

        $postalCode = $_POST['postal-code'];
        $town = $_POST['town'];
        $country = $_POST['country'];

        $manager = new AddressManager();
        if ($manager->addAddress($userId, $streetNumber, $streetName, (int)$postalCode, $town, $country)) {
            header("Location: payment");
        } else {
            $_SESSION['message'] = "Error saving address.";
            header("Location: address");
        }
        exit;
    }
}


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
                $_SESSION['error_message'] = "Tous les champs sont requis.";
                header("Location: address");
                exit;
            }
        }
    }

    public function display() {
        $error = $_SESSION['error_message'] ?? '';
        unset($_SESSION['error_message']);
        $success = $_SESSION['success_message'] ?? '';
        unset($_SESSION['success_message']);

        $template = "address.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }

    private function processAddressForm() {
        $userId = $_SESSION['user_id'] ?? null; // Ensure you have this session set. Add validation for userId if needed.

        // Validation
        $street = trim($_POST['street']);
        if (empty($street) || !preg_match('/^\d+\s+[\p{L}\s]+/u', $street)) {
            $_SESSION['error_message'] = 'Entrez un numéro et un nom de rue valide.';
            header("Location: address");
            exit;
        }

        $parts = explode(' ', $street, 2);
        $streetNumber = $parts[0];
        $streetName = $parts[1] ?? ''; // Provide a default empty string if the name part is missing

        $postalCode = $_POST['postal-code'];
        $town = $_POST['town'];
        $country = $_POST['country'];

        // Assuming AddressManager and its addAddress method handle these values correctly
        $manager = new AddressManager();
        if ($manager->addAddress($userId, $streetNumber, $streetName, (int)$postalCode, $town, $country)) {
            // Redirect or show a success message after saving the address
            $_SESSION['success_message'] = "Address saved successfully.";
            header("Location: payment");
        } else {
            // Handle saving error
            $_SESSION['error_message'] = "Error saving address.";
            header("Location: address");
        }
        exit;
    }
}













// require_once 'models/Address.php';
// require_once 'models/AddressManager.php';

// class AddressController {
//     public function __construct()
//     {

//         // $error = "construct";
//         // echo "construct";
//         if (isset($_POST['street'], $_POST['postal-code'], $_POST['town'], $_POST['country'])) {
//             echo $_POST['street'] . " _ " . $_POST['postal-code'] . " _ " .  $_POST['town'] . " _ " .  $_POST['country'];
//             $this->processAddressForm();
//         }
//         else {
//             $_SESSION['error_message'] = "Tous les champs sont requis.";
//             header("Location: address");
//             exit;
//         }
//     }

//     public function display() {
//         $error = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
//         unset($_SESSION['error_message']);
//         $template = "address.phtml";
//         $cart = "cartComponent.phtml";
//         require_once "views/layout.phtml";
//     }

//     public function processAddressForm(){
//         // Assume user_id comes from a logged-in user session or a similar mechanism
//         $userId = $_SESSION['user_id']; // Example, ensure you have this session set
    
//         // Validation

//         $street = trim($_POST['street']);
//         if (empty($street) || !preg_match('/^\d+\s+[\p{L}\s]+/u', $street)) {
//             $error = 'Entrez un numéro et un nom de rue valide.';
//             return;
//         }
    
//         $street = explode(' ', $street, 2);
//         $streetNumber = $street[0];
//         $streetName = $street[1] ?? ''; // Provide a default empty string if the name part is missing
            
            
//             $postalCode = $_POST['postal-code'];
//             $town = $_POST['town'];
//             $country = $_POST['country'];
            
//             $manager = new AddressManager();
//             $manager->addAddress($userId, $streetNumber, $streetName, $postalCode, $town, $country);

//         //     // Prepare SQL statement to avoid SQL injection
//         //     $stmt = $this->db->prepare("INSERT INTO address (user_id, street_number, street_name, postal_code, town, country) VALUES (?, ?, ?, ?, ?, ?)");
    
//         //     // Bind parameters and execute
//         //     $stmt->bind_param("isssss", $userId, $streetNumber, $streetName, $postalCode, $town, $country);
    
//         //     if ($stmt->execute()) {
//         //         echo "Address saved successfully";
//         //     } else {
//         //         echo "Error saving address: " . $stmt->error;
//         //     }
    
//         //     $stmt->close();
//         // } else {
//         //     echo "Please fill in all the required fields.";
//         // }
//     }
    
// }
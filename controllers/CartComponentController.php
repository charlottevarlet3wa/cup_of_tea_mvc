<?php 

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

class CartComponentController {
    public function display() {
        // $template = "cart.phtml";
        // require_once "views/layout.phtml";
    }


    function addToCart($teaId, $formatId) {
        // echo "teaId :  " . $teaId;
        $manager = new TeaManager();
        $tea = $manager->getTeaById($teaId); // Implement this function based on your database
        $formats = $manager->getFormatsByTea($teaId);
        $format = $formats[$formatId];

        // Check if the tea is already in the cart
        if (isset($_SESSION['cart'][$teaId])) {
            // Check if this specific format is already in the cart for this tea
            if (isset($_SESSION['cart'][$teaId]['formats'][$formatId])) {
                // If so, just increment the quantity of this format
                $_SESSION['cart'][$teaId]['formats'][$formatId]['quantity'] += 1;
            } else {
                // If this format is not in the cart, add it with quantity 1
                $_SESSION['cart'][$teaId]['formats'][$formatId] = [
                    'format' => $format['conditioning'],
                    'price' => $format['price'],
                    'quantity' => 1
                ];
            }
        } else {
            // If the tea is not in the cart at all, add it with this format
            $_SESSION['cart'][$teaId] = [
                'name' => $tea['name'],
                'formats' => [
                    $formatId => [
                        'format' => $format['conditioning'],
                        'price' => $format['price'],
                        'quantity' => 1
                    ]
                ]
            ];
        }

    }

    function removeFromCart($teaId, $formatId) {
        // Check if the tea and format exist in the cart
        if (isset($_SESSION['cart'][$teaId], $_SESSION['cart'][$teaId]['formats'][$formatId])) {
            // If the quantity is more than 1, just decrement the quantity
            if ($_SESSION['cart'][$teaId]['formats'][$formatId]['quantity'] > 1) {
                $_SESSION['cart'][$teaId]['formats'][$formatId]['quantity'] -= 1;
            } else {
                // If the quantity is 1, remove this format from the tea
                unset($_SESSION['cart'][$teaId]['formats'][$formatId]);
                // If there are no more formats for this tea, remove the tea from the cart
                if (empty($_SESSION['cart'][$teaId]['formats'])) {
                    unset($_SESSION['cart'][$teaId]);
                }
            }
        }
    }

    function changeCartQuantity($teaId, $formatId, $quantity) {
        // Check if the tea and format exist in the cart
        if (isset($_SESSION['cart'][$teaId], $_SESSION['cart'][$teaId]['formats'][$formatId])) {
            if ($quantity > 0) {
                // Update the quantity directly
                $_SESSION['cart'][$teaId]['formats'][$formatId]['quantity'] = $quantity;
            } else {
                // Remove this format from the tea
                unset($_SESSION['cart'][$teaId]['formats'][$formatId]);
                // If there are no more formats for this tea, remove the tea from the cart
                if (empty($_SESSION['cart'][$teaId]['formats'])) {
                    unset($_SESSION['cart'][$teaId]);
                }
            }
        }
    }
    
    

    function calculateTotal() {
        $total = 0;
        // foreach ($_SESSION['cart'] as $item) {
        //     $total += $item['price'] * $item['quantity'];
        // }
        foreach($_SESSION['cart'] as $tea){
            foreach($tea['formats'] as $format){
                $total += $format['price'] * $format['quantity'];
            }
        }
        return $total;
    }

    function displayCartHeader(){
        $total = calculateTotal();
        return $total;
    }
    
}
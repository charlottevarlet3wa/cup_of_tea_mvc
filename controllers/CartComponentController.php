<?php 

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

class CartHeaderController {


    function addToCart() {
        $teaId = $_POST['teaId'] ?? null;
        $formatId = $_POST['formatId'] ?? null;
        
        $manager = new TeaManager();
        $tea = $manager->getTeaById($teaId); 
        $formats = $manager->getFormatsByTea($teaId);
        $format = $formats[$formatId];

        if (isset($_SESSION['cart'][$teaId])) {
            if (isset($_SESSION['cart'][$teaId]['formats'][$formatId])) {
                $_SESSION['cart'][$teaId]['formats'][$formatId]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$teaId]['formats'][$formatId] = [
                    'format' => $format['conditioning'],
                    'price' => $format['price'],
                    'quantity' => 1
                ];
            }
        } else {
            $_SESSION['cart'][$teaId] = [
                'name' => $tea['name'],
                'formats' => [
                    $formatId => [
                        'format' => $format['conditioning'],
                        'price' => $format['price'],
                        'quantity' => 1
                    ]
                ],
                'stock' => $tea['stock']
            ];
        }

    }

    function removeFromCart() {
        $teaId = $_POST['teaId'] ?? null;
        $formatId = $_POST['formatId'] ?? null;

        if (isset($_SESSION['cart'][$teaId], $_SESSION['cart'][$teaId]['formats'][$formatId])) {
            if ($_SESSION['cart'][$teaId]['formats'][$formatId]['quantity'] > 1) {
                $_SESSION['cart'][$teaId]['formats'][$formatId]['quantity'] -= 1;
            } else {
                unset($_SESSION['cart'][$teaId]['formats'][$formatId]);
                if (empty($_SESSION['cart'][$teaId]['formats'])) {
                    unset($_SESSION['cart'][$teaId]);
                }
            }
        }
    }

    function changeCartQuantity() {
        $teaId = $_POST['teaId'] ?? null;
        $formatId = $_POST['formatId'] ?? null;
        $quantity = $_POST['quantity'] ?? null;

        if (isset($_SESSION['cart'][$teaId], $_SESSION['cart'][$teaId]['formats'][$formatId])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$teaId]['formats'][$formatId]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$teaId]['formats'][$formatId]);
                if (empty($_SESSION['cart'][$teaId]['formats'])) {
                    unset($_SESSION['cart'][$teaId]);
                }
            }
        }
    }
    
    

    function calculateTotal() {
        $total = 0;
        foreach($_SESSION['cart'] as $tea){
            foreach($tea['formats'] as $format){
                $total += $format['price'] * $format['quantity'];
            }
        }
        return number_format($total, 2);
    }

    function calculateCount() {
        $count = 0;
        foreach($_SESSION['cart'] as $tea){
            foreach($tea['formats'] as $format){
                $count += $format['quantity'];
            }
        }
        return $count;
    }

    function displayCartHeader(){
        $total = $this->calculateTotal();
        $count = $this->calculateCount();
        return $total;
    }

    public function updateDisplayCartHeader(){
        $teaId = $_POST['teaId'] ?? null;
        $formatId = $_POST['formatId'] ?? null;
        $quantity = $_POST['quantity'] ?? null;

        $response = [
            'total' => $this->calculateTotal(),
            'count' => $this->calculateCount()
        ];
        echo json_encode($response);
    }
    
}
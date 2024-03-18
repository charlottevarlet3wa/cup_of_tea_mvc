<?php

require_once 'models/User.php';
require_once 'models/UserManager.php';

class PaymentController
{
    public function __construct()
    {

        // Si on est dans une requête post, alors on lance la méthode addRoom(). 
        if (!empty($_POST) && isset($_POST['card_number'])) {
            $this->processPayment();
        }
    }

    public function display(){
        $template = "payment.phtml";
        $cart = "cartComponent.phtml";
        require_once "views/layout.phtml";
    }

    function processPayment()
    {


        // Initialisation du client stripe
        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $card_number = htmlspecialchars(strip_tags($_POST['card_number']));
            $exp_date = htmlspecialchars(strip_tags($_POST['exp_date']));
            $cvv = htmlspecialchars(strip_tags($_POST['cvv']));

            $exp_date = explode('/', $exp_date);

            // if (isset($_POST['amount'])) {
            //     $amount = htmlspecialchars(strip_tags($_POST['amount']));
            //     if ($amount == 'custom') {
            //         $amount = htmlspecialchars(strip_tags($_POST['customAmount']));
            //     }
            // }
            
                        // if (!is_numeric($amount) || $amount <= 0 || $amount > 1000000) {
                        //     die("Montant invalide");
                        // }

            // $amount = $_SESSION['cart'];

            // $amount *= 100;
            $amount = calculateTotal() * 100;

            try {
                // En mode test, Stripe fournit des cartes bancaires pré-tokenisées :
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $amount,
                    'currency' => 'eur',
                    'payment_method' => 'pm_card_visa',
                    'confirm' => true,
                    'return_url' => 'http://localhost/cup_of_tea_php/home',
                ]);

                if ($paymentIntent->status == 'succeeded') {
                    unset($_SESSION['cart']);
                    header('Location: http://localhost/cup_of_tea_php/success');
                    exit();
                }
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }

            /* 
    // Le token est une représentation sécurisée de la carte bancaire
    // En mode production le token ressemblerait à ça :
    $token = \Stripe\Token::create([
        'card' => [
            'number' => $card_number,
            'exp_month' => trim($exp_date[0]),
            'exp_year' => trim($exp_date[1]),
            'cvc' => $cvv
        ],
    ]);

    // On crée une "charge" autrement dit un paiement
    $charge = \Stripe\Charge::create([
        'amount' => $amount,
        'currency' => 'eur',
        'source' => $token->id,
    ]);
    */
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
}

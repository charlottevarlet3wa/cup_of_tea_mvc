<?php

require_once 'models/User.php';
require_once 'models/UserManager.php';
require_once 'models/Order.php';
require_once 'models/OrderDetails.php';
require_once 'models/OrderManager.php';

class PaymentController
{
    public function __construct()
    {
        if (!empty($_POST) && isset($_POST['card_number'])) {
            $this->processPayment();
        }
    }

    public function display(){
        if(!isset($_SESSION['user_id'])){
            header('Location: login');
            exit;
        }
        $amount = $this->calculateTotal();
        $message = $_SESSION['message'] ?? '';
        unset($_SESSION['message']);
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

        // Remplacez les valeurs récupérées par POST par les valeurs de test Stripe
            // $card_number = "4242424242424242"; // Numéro de carte de test Stripe
            // $exp_month = 12; // Mois d'expiration futur
            // $exp_year = (int)date("Y") + 1; // Année d'expiration (année actuelle + 1)
            // $cvv = "123"; // CVC quelconque

            $amount = $this->calculateTotal() * 100;

            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $domainName = $_SERVER['HTTP_HOST'].'/';

            $returnUrl = $protocol . $domainName . "cup_of_tea_php/home";
    
            try {
                // En mode test, Stripe fournit des cartes bancaires pré-tokenisées :
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $amount,
                    'currency' => 'eur',
                    'payment_method' => 'pm_card_visa',
                    'confirm' => true,
                    'return_url' => $returnUrl,
                ]);
    
                if ($paymentIntent->status == 'succeeded') {
                    $manager = new OrderManager();
                    
                    $teas = [];
                    foreach($_SESSION['cart'] as $teaId => $teaDetails) {
                        foreach ($teaDetails['formats'] as $format) {
                            $teas[] = [
                                'id' => $teaId,
                                'cond' => $format['format'],
                                'price' => $format['price'] * $format['quantity'],
                            ];
                        }
                    }
    
                    if($manager->addOrder($_SESSION['user_id'], $teas)) {
                        unset($_SESSION['cart']);
                        header('Location: success');
                        exit();
                    } else {
                        $_SESSION['message'] = "Erreur lors de l'ajout de la commande.";
                        header('Location: my-account');
                        exit;
                    }
                }
            } catch (Exception $e) {
                $_SESSION['message'] = $e->getMessage() ;
                header('Location: my-account');
                exit;
            }
        }
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

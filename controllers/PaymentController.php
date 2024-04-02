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

        // Si on est dans une requête post, alors on lance la méthode addRoom(). 
        if (!empty($_POST) && isset($_POST['card_number'])) {
            $this->processPayment();
        }
    }

    public function display(){
        $amount = $this->calculateTotal();
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
                    // Instancier OrderManager
                    $manager = new OrderManager();
                    
                    // Préparer les données des thés pour passer à addOrder
                    $teas = []; // Vous devez convertir votre $_SESSION['cart'] en un format attendu par addOrder
                    foreach($_SESSION['cart'] as $teaId => $teaDetails) {
                        foreach ($teaDetails['formats'] as $format) {
                            $teas[] = [
                                'id' => $teaId,
                                'cond' => $format['format'], // Exemple: 'Pochette de 100g'
                                'price' => $format['price'] * $format['quantity'], // calcule le prix total pour ce format
                            ];
                        }
                    }
    
                    // Appeler addOrder
                    if($manager->addOrder($_SESSION['user_id'], $teas)) {
                        unset($_SESSION['cart']);
                        header('Location: /cup_of_tea_php/success');
                        exit();
                    } else {
                        // Gérer l'échec de l'ajout de la commande
                        echo "Erreur lors de l'ajout de la commande.";
                    }
                }
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
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

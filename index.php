<?php

declare(strict_types=1);

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}




// Stripe
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// Routeur
require 'services/routing.php';



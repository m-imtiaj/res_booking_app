<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test'); 

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $amount = $data['amount']; // Amount in cents

    // Create PaymentIntent
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'usd',
        'payment_method_types' => ['card'],
    ]);

    echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

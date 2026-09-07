<?php

declare(strict_types=1);

use PaymentEngine\Sdk\Client\PaymentEngineClient;
use PaymentEngine\Teachable\Support\ChargePayloadBuilder;
use PaymentEngine\Teachable\Support\PaymentIdentifier;
use PaymentEngine\Teachable\Support\CallbackUrl;
use PaymentEngine\Teachable\Support\TeachableBootstrap;

require_once dirname(__DIR__) . '/src/Support/TeachableBootstrap.php';

TeachableBootstrap::registerAutoload();

$client = new PaymentEngineClient(
    (string) getenv('PAYMENT_ENGINE_BASE_URL'),
    (string) getenv('PAYMENT_ENGINE_SECRET_KEY')
);

$paymentIdentifier =
    PaymentIdentifier::build(
        (int) $_POST['userId'],
        (int) $_POST['courseId']
    );

$payload =
    ChargePayloadBuilder::fromRequest(
        $_POST,
        $paymentIdentifier,
        CallbackUrl::forGateway()
    );

$response =
    $client->redirectCheckout
        ->initiate($payload);

$paymentLink = (string) ($response['data']['paymentLink'] ?? '');

if (!filter_var($paymentLink, FILTER_VALIDATE_URL)) {
    throw new RuntimeException('Remita Checkout returned an invalid payment link.');
}

header('Location: ' . $paymentLink);
exit;

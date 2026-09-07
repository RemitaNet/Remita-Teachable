<?php

declare(strict_types=1);

use PaymentEngine\Teachable\Support\CallbackUrl;
use PaymentEngine\Teachable\Support\TeachableBootstrap;

require_once dirname(__DIR__) . '/src/Support/TeachableBootstrap.php';

TeachableBootstrap::registerAutoload();

return [

    'name' => 'Remita Checkout',

    'configuration' => [

        'base_url' => [
            'label' => 'API Base URL',
            'type' => 'text',
            'default' => 'https://api-checkout-qa.systemspecsng.com',
        ],

        'secret_key' => [
            'label' => 'Secret Key',
            'type' => 'password',
        ],

        'callback_url' => [
            'label' => 'Callback URL',
            'type' => 'text',
            'default' => CallbackUrl::forPlugin(),
        ],
    ],
];

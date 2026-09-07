<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Tests;

use PHPUnit\Framework\TestCase;
use PaymentEngine\Teachable\Support\CallbackUrl;

final class CallbackUrlTest extends TestCase
{
    public function testGatewayUrl(): void
    {
        putenv('TEACHABLE_URL=https://school.example.com');

        $this->assertSame(
            'https://school.example.com/paymentengine/callback.php',
            CallbackUrl::forGateway()
        );
    }
}
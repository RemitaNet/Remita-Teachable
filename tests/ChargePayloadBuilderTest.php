<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Tests;

use PHPUnit\Framework\TestCase;
use PaymentEngine\Teachable\Support\ChargePayloadBuilder;

final class ChargePayloadBuilderTest extends TestCase
{
    public function testPayloadCreation(): void
    {
        $payload =
            ChargePayloadBuilder::fromRequest(
                [
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'email' => 'john@example.com',
                    'phoneNumber' => '08012345678',
                    'amount' => '10000',
                    'currency' => 'NGN',
                    'courseName' => 'Spring Boot'
                ],
                'TEACH-1-10-123',
                'https://example.com/callback'
            );

        $this->assertSame(
            'TEACH-1-10-123',
            $payload['paymentIdentifier']
        );

        $this->assertSame(
            1000000,
            $payload['amount']
        );

        $this->assertSame(
            'Spring Boot',
            $payload['narration']
        );
    }
}
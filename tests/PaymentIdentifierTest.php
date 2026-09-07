<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Tests;

use PHPUnit\Framework\TestCase;
use PaymentEngine\Teachable\Support\PaymentIdentifier;

final class PaymentIdentifierTest extends TestCase
{
    public function testBuildIdentifier(): void
    {
        $identifier =
            PaymentIdentifier::build(
                10,
                25
            );

        $this->assertStringStartsWith(
            'TEACH-10-25-',
            $identifier
        );
    }
}
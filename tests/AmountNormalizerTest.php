<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Tests;

use PHPUnit\Framework\TestCase;
use PaymentEngine\Teachable\Support\AmountNormalizer;

final class AmountNormalizerTest extends TestCase
{
    public function testToKobo(): void
    {
        $this->assertSame(
            1500000,
            AmountNormalizer::toKobo('15000')
        );
    }

    public function testFromKobo(): void
    {
        $this->assertSame(
            15000.00,
            AmountNormalizer::fromKobo(1500000)
        );
    }
}
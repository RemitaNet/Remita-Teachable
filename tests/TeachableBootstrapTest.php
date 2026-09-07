<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Tests;

use PHPUnit\Framework\TestCase;
use PaymentEngine\Teachable\Support\TeachableBootstrap;

final class TeachableBootstrapTest extends TestCase
{
    public function testBootstrapMethodExists(): void
    {
        $this->assertTrue(
            method_exists(
                TeachableBootstrap::class,
                'registerAutoload'
            )
        );
    }
}
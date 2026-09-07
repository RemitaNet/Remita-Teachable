<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Tests;

use PHPUnit\Framework\TestCase;
use PaymentEngine\Teachable\Support\PaymentStatusMapper;

final class PaymentStatusMapperTest extends TestCase
{
    public function testSuccessStatus(): void
    {
        $response = [
            'status' => '00'
        ];

        $this->assertSame(
            PaymentStatusMapper::STATUS_SUCCESS,
            PaymentStatusMapper::mapQueryResponse(
                $response
            )
        );
    }

    public function testPendingStatus(): void
    {
        $response = [
            'status' => '01'
        ];

        $this->assertSame(
            PaymentStatusMapper::STATUS_PENDING,
            PaymentStatusMapper::mapQueryResponse(
                $response
            )
        );
    }

    public function testFailedStatus(): void
    {
        $response = [
            'status' => '99'
        ];

        $this->assertSame(
            PaymentStatusMapper::STATUS_FAILED,
            PaymentStatusMapper::mapQueryResponse(
                $response
            )
        );
    }
}
<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Support;

final class PaymentStatusMapper
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_PENDING = 'pending';
    public const STATUS_FAILED = 'failed';

    public static function mapQueryResponse(
        array $response
    ): string {

        $numericStatus = strtoupper(
            (string) ($response['status'] ?? '')
        );

        $paymentState = strtoupper(
            (string) ($response['data']['paymentState'] ?? '')
        );

        if (
            $numericStatus === '00'
            || $paymentState === 'APPROVED'
        ) {
            return self::STATUS_SUCCESS;
        }

        if (
            in_array(
                $numericStatus,
                ['01', '02', '03', '04', '09', '45'],
                true
            )
        ) {
            return self::STATUS_PENDING;
        }

        return self::STATUS_FAILED;
    }

    public static function mapEventPayload(
        array $payload
    ): string {
        return self::mapQueryResponse([
            'status' => (string) ($payload['status'] ?? ''),
            'data' => is_array($payload['data'] ?? null) ? $payload['data'] : [],
        ]);
    }
}

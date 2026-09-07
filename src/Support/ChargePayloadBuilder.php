<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Support;

final class ChargePayloadBuilder
{
    public static function fromRequest(
        array $request,
        string $paymentIdentifier,
        string $returnUrl
    ): array {

        $courseName =
            trim(
                (string) ($request['courseName'] ?? '')
            );

        return [
            'firstName' => trim((string) ($request['firstName'] ?? '')),
            'lastName' => trim((string) ($request['lastName'] ?? '')),
            'email' => trim((string) ($request['email'] ?? '')),
            'phoneNumber' => trim((string) ($request['phoneNumber'] ?? '')),
            'paymentIdentifier' => $paymentIdentifier,
            'currency' => trim((string) ($request['currency'] ?? 'NGN')),
            'narration' => $courseName !== ''
                ? $courseName
                : 'Teachable Course Purchase',
            'amount' => AmountNormalizer::toKobo(
                (string) ($request['amount'] ?? '0')
            ),
            'returnUrl' => trim($returnUrl),
        ];
    }
}

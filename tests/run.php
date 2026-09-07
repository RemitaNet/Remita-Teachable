<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/src/Support/TeachableBootstrap.php';

\PaymentEngine\Teachable\Support\TeachableBootstrap::registerAutoload();

use PaymentEngine\Teachable\Support\CallbackUrl;
use PaymentEngine\Teachable\Support\ChargePayloadBuilder;
use PaymentEngine\Teachable\Support\EnrollmentReference;
use PaymentEngine\Teachable\Support\PaymentIdentifier;
use PaymentEngine\Teachable\Support\PaymentStatusMapper;
use PaymentEngine\Teachable\Support\TransactionVerifier;

$tests = [];

$assertSame = static function (mixed $expected, mixed $actual, string $message): void {
    if ($expected !== $actual) {
        throw new RuntimeException($message . ' Expected ' . var_export($expected, true) . ', got ' . var_export($actual, true));
    }
};

$assertTrue = static function (bool $condition, string $message): void {
    if (!$condition) {
        throw new RuntimeException($message);
    }
};

$tests['callback_and_result_urls'] = static function () use ($assertSame): void {
    putenv('TEACHABLE_URL=https://school.example.com');
    $assertSame('https://school.example.com/plugin/callback.php', CallbackUrl::forPlugin(), 'Unexpected Teachable callback URL.');
    $assertSame('https://school.example.com?payment_status=success&course_id=10', CallbackUrl::resultUrl(10, 'success'), 'Unexpected Teachable result URL.');
};

$tests['payment_identifier_and_reference'] = static function () use ($assertTrue, $assertSame): void {
    $identifier = PaymentIdentifier::build(10, 25);
    $assertTrue(str_starts_with($identifier, 'TEACH-10-25-'), 'Unexpected Teachable payment identifier format.');
    $assertSame('ENR-5-100', EnrollmentReference::build(5, 100), 'Unexpected Teachable enrollment reference.');
};

$tests['charge_payload_builder'] = static function () use ($assertSame): void {
    $payload = ChargePayloadBuilder::fromRequest([
        'firstName' => 'John',
        'lastName' => 'Doe',
        'email' => 'john@example.com',
        'phoneNumber' => '08012345678',
        'amount' => '10000',
        'currency' => 'NGN',
        'courseName' => 'Spring Boot',
    ], 'TEACH-1-10-123', 'https://school.example.com/plugin/callback.php');

    $assertSame(1000000, $payload['amount'], 'Unexpected Teachable amount conversion.');
    $assertSame('Spring Boot', $payload['narration'], 'Unexpected Teachable narration.');

    $defaultPayload = ChargePayloadBuilder::fromRequest([
        'amount' => '5000',
    ], 'TEACH-1-10-123', 'https://school.example.com/plugin/callback.php');

    $assertSame('Teachable Course Purchase', $defaultPayload['narration'], 'Unexpected Teachable default narration.');
};

$tests['payment_status_mapping'] = static function () use ($assertSame): void {
    $assertSame(PaymentStatusMapper::STATUS_SUCCESS, PaymentStatusMapper::mapQueryResponse(['status' => '00']), 'Unexpected Teachable success mapping.');
    $assertSame(PaymentStatusMapper::STATUS_PENDING, PaymentStatusMapper::mapQueryResponse(['status' => '01']), 'Unexpected Teachable pending mapping.');
    $assertSame(PaymentStatusMapper::STATUS_FAILED, PaymentStatusMapper::mapQueryResponse(['status' => '99']), 'Unexpected Teachable failed mapping.');
};

$tests['transaction_verifier_with_injected_query'] = static function () use ($assertSame): void {
    $response = TransactionVerifier::verify('https://api-checkout-qa.systemspecsng.com', 'secret', 'TEACH-1-10-123', static fn (string $paymentIdentifier): array => [
        'status' => '00',
        'data' => [
            'paymentIdentifier' => $paymentIdentifier,
            'paymentState' => 'APPROVED',
        ],
    ]);

    $assertSame('TEACH-1-10-123', $response['data']['paymentIdentifier'], 'Unexpected injected Teachable verifier response.');
};

$executed = 0;

foreach ($tests as $name => $test) {
    $test();
    $executed++;
    echo "[PASS] {$name}\n";
}

echo "\nAll {$executed} Teachable tests passed.\n";

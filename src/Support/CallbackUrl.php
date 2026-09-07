<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Support;

final class CallbackUrl
{
    private static function getBaseUrl(): string
    {
        return rtrim((string) (getenv('TEACHABLE_URL') ?: getenv('APP_URL')), '/');
    }

    public static function forGateway(): string
    {
        return self::getBaseUrl() . '/plugin/callback.php';
    }

    public static function forPlugin(): string
    {
        return self::forGateway();
    }

    public static function resultUrl(
        int $courseId,
        string $status = ''
    ): string {
        $url = self::getBaseUrl();

        if ($status !== '') {
            $separator = str_contains($url, '?') ? '&' : '?';
            $url .= $separator . 'payment_status=' . urlencode($status);
        }

        if ($courseId > 0) {
            $separator = str_contains($url, '?') ? '&' : '?';
            $url .= $separator . 'course_id=' . $courseId;
        }

        return $url;
    }
}

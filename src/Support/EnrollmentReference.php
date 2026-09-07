<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Support;

final class EnrollmentReference
{
    public static function build(
        int $studentId,
        int $courseId
    ): string {

        return sprintf(
            'ENR-%d-%d',
            $studentId,
            $courseId
        );
    }

    public static function extractStudentId(
        string $reference
    ): ?int {

        $parts = explode('-', $reference);

        return isset($parts[1])
            ? (int) $parts[1]
            : null;
    }

    public static function extractCourseId(
        string $reference
    ): ?int {

        $parts = explode('-', $reference);

        return isset($parts[2])
            ? (int) $parts[2]
            : null;
    }
}
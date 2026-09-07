<?php

declare(strict_types=1);

namespace PaymentEngine\Teachable\Tests;

use PHPUnit\Framework\TestCase;
use PaymentEngine\Teachable\Support\EnrollmentReference;

final class EnrollmentReferenceTest extends TestCase
{
    public function testBuildReference(): void
    {
        $this->assertSame(
            'ENR-5-100',
            EnrollmentReference::build(
                5,
                100
            )
        );
    }

    public function testExtractStudentId(): void
    {
        $this->assertSame(
            5,
            EnrollmentReference::extractStudentId(
                'ENR-5-100'
            )
        );
    }

    public function testExtractCourseId(): void
    {
        $this->assertSame(
            100,
            EnrollmentReference::extractCourseId(
                'ENR-5-100'
            )
        );
    }
}
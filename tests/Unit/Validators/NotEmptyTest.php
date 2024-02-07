<?php

declare(strict_types=1);

namespace Tests\Unit\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\NotEmptyException;
use MyOriginalCodes\ApolloPhp\Validators\NotEmpty;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class NotEmptyTest extends TestCase
{
    use NotEmpty;

    private static bool $throwExceptions;

    private static array $errorsBag;

    public function setUp(): void
    {
        self::$throwExceptions = false;
        self::$errorsBag = [];
    }

    #[Test]
    public function ensureValidationWorksUsingEmptyArray(): void
    {
        $this->notEmpty([], 'field');

        $this->assertArrayHasKey('field', self::$errorsBag);   
    }

    #[Test]
    public function ensureValidationWorksUsingEmptyString(): void
    {
        $this->notEmpty('', 'field');

        $this->assertArrayHasKey('field', self::$errorsBag);   
    }

    #[Test]
    public function ensureValidationThrownsExceptionsWhenAttributeIsSetToTrue(): void
    {
        self::$throwExceptions = true;

        $this->expectException(NotEmptyException::class);

        $this->notEmpty('', 'field');
    }
}

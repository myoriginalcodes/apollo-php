<?php

declare(strict_types=1);

namespace Tests\Unit\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\RequiredException;
use MyOriginalCodes\ApolloPhp\Validators\Required;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RequiredTest extends TestCase
{
    use Required;

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
        $this->required([], 'field');

        $this->assertEmpty(self::$errorsBag);   
    }

    #[Test]
    public function ensureValidationWorksUsingEmptyString(): void
    {
        $this->required('', 'field');

        $this->assertEmpty(self::$errorsBag);   
    }
    
    #[Test]
    public function ensureValidationWorksUsingNullValue(): void
    {
        $this->required(null, 'field');

        $this->assertArrayHasKey('field', self::$errorsBag);
    }

    #[Test]
    public function ensureValidationThrownsExceptionsWhenAttributeIsSetToTrue(): void
    {
        self::$throwExceptions = true;

        $this->expectException(RequiredException::class);

        $this->required(null, 'field');
    }
}

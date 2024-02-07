<?php

declare(strict_types=1);

namespace Tests\Unit\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\OnlyLettersException;
use MyOriginalCodes\ApolloPhp\Validators\OnlyLetters;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OnlyLettersTest extends TestCase
{
    use OnlyLetters;

    private static bool $throwExceptions = false;

    private static array $errorsBag = [];

    #[Test]
    #[DataProvider('stringsDataProvider')]
    public function ensureValidationWorksUsingValidStrings(string $value, string $bagKey): void
    {
        $this->onlyLetters($value, $bagKey);

        $this->assertEmpty(self::$errorsBag);
    }

    #[Test]
    #[DataProvider('invalidStringsDataProvider')]
    public function ensureValidationNotAcceptsCharsOtherThanLetters(string $value, string $bagKey): void
    {
        $this->onlyLetters($value, $bagKey);

        $this->assertArrayHasKey($bagKey, self::$errorsBag);
    }

    #[Test]
    #[DataProvider('invalidStringsDataProvider')]
    public function ensureValidationThrownsExceptionsWhenAttributeIsSetToTrue(string $value, string $bagKey): void
    {
        self::$throwExceptions = true;

        $this->expectException(OnlyLettersException::class);

        $this->onlyLetters($value, $bagKey);
    }

    public static function stringsDataProvider(): array
    {
        return [
            'empty' => ['', 'field1'],
            'mixed' => ['AbcDEfG', 'field2'],
            'lowercase' => ['car', 'field3'],
            'uppercase' => ['CAR', 'field4'],
            'capitalized' => ['Car', 'field5'],
        ];
    }

    public static function invalidStringsDataProvider(): array
    {
        return [
          'mixed' => ['Abc1', 'field1'],
          'numbers' => ['123', 'field2'],
          'special_chars' => ['123-', 'field3'],
        ];
    }
}

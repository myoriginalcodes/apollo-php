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
    
    private static bool $throwExceptions;

    private static array $errorsBag;

    public function setUp(): void
    {
        self::$throwExceptions = false;
        self::$errorsBag = [];
    }

    #[Test]
    #[DataProvider('validStringsDataProvider')]
    public function ensureValidationWorksUsingValidValues(string $value, string $bagKey): void
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

    #[Test]
    public function shouldAcceptSpacesWhenTheParameterIsTrue(): void
    {
        $this->onlyLetters("string with spaces", "field", ['allow_spaces' => true]);
        $this->assertEmpty(self::$errorsBag);
    }

    public static function validStringsDataProvider(): array
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
          'space' => [' ', 'field1'],
          'mixed' => ['Abc1', 'field2'],
          'numbers' => ['123', 'field3'],
          'special_chars' => ['123-', 'field4'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\OnlyNumbersException;
use MyOriginalCodes\ApolloPhp\Validators\OnlyNumbers;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OnlyNumbersTest extends TestCase
{
    use OnlyNumbers;

    private static bool $throwExceptions = false;

    private static array $errorsBag = [];

    #[Test]
    #[DataProvider('numbersDataProvider')]
    public function ensureValidationWorksUsingValidNumbers(string $value, string $bagKey): void
    {
        $this->onlyNumbers($value, $bagKey);

        $this->assertEmpty(self::$errorsBag);
    }

    #[Test]
    #[DataProvider('invalidNumbersDataProvider')]
    public function ensureValidationNotAcceptsCharsOtherThanNumbers(string $value, string $bagKey): void
    {
        $this->onlyNumbers($value, $bagKey);

        $this->assertArrayHasKey($bagKey, self::$errorsBag);
    }

    #[Test]
    #[DataProvider('invalidNumbersDataProvider')]
    public function ensureValidationThrownsExceptionsWhenAttributeIsSetToTrue(string $value, string $bagKey): void
    {
        self::$throwExceptions = true;

        $this->expectException(OnlyNumbersException::class);

        $this->onlyNumbers($value, $bagKey);
    }

    public static function numbersDataProvider(): array
    {
        return [
            'empty' => ['', 'field1'],
            'integer' => ['123', 'field2'],
            'float_dot' => ['123.50', 'field3'],
            'float_comma' => ['123,50', 'field4'],
            'float_mixed' => ['1.250,00', 'field5']
        ];
    }

    public static function invalidNumbersDataProvider(): array
    {
        return [
          'mixed' => ['Abc1', 'field1'],
          'letters' => ['abc', 'field2'],
          'special_chars' => ['123-', 'field3'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\LengthException;
use MyOriginalCodes\ApolloPhp\Validators\Length;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LengthTest extends TestCase
{
    use Length;

    private static bool $throwExceptions;

    private static array $errorsBag;

    public function setUp(): void
    {
        self::$throwExceptions = false;
        self::$errorsBag = [];
    }

    #[Test]
    #[DataProvider('validValuesDataProvider')]
    public function ensureValidationWorksUsingValidValues(string $value, string $bagKey, array $args): void
    {
        $this->length($value, $bagKey, $args);

        $this->assertEmpty(self::$errorsBag);
    }

    #[Test]
    public function ensureMinLengthValidationWorks(): void
    {
        $this->length('abc', 'field', ['min' => 4]);

        $this->assertArrayHasKey('field', self::$errorsBag);
    }

    #[Test]
    public function ensureMaxLentghValidationWorks(): void
    {
        $this->length('abc', 'field', ['max' => 2]);

        $this->assertArrayHasKey('field', self::$errorsBag);   
    }

    #[Test]
    public function ensureMinLengthAndMaxLengthValidationsWorkTogetherForMultipleFields(): void
    {
        $this->length('abcdef', 'field1', ['min' => 3, 'max' => 5]);

        $this->assertArrayHasKey('field1', self::$errorsBag);

        $this->length('abcdef', 'field2', ['min' => 7, 'max' => 10]);

        $this->assertArrayHasKey('field2', self::$errorsBag);
    }

    #[Test]
    #[DataProvider('invalidValuesDataProvider')]
    public function ensureValidationThrownsExceptionsWhenAttributeIsSetToTrue(string $value, string $bagKey, array $args): void
    {
        self::$throwExceptions = true;

        $this->expectException(LengthException::class);

        $this->Length($value, $bagKey, $args);
    }

    public static function validValuesDataProvider(): array
    {
        return [
            'empty_without_min_max' => ['', 'field1', []],
            'empty_using_min' => ['', 'field2', ['min' => 0]],
            'empty_using_max' => ['', 'field3', ['max' => 10]],
            'mixed_string' => ['abc123', 'field4', ['max' => 10]],
            'edge_case_min' => ['abc123', 'field5', ['min' => 6]],
            'edge_case_max' => ['abc123', 'field6', ['max' => 6]],
            'min_and_max_equals' => ['abc123', 'field7', ['min' => 6, 'max' => 6]],
        ];
    }

    public static function invalidValuesDataProvider(): array
    {
        return [
            'value_smaller_than_min' => ['AbcDef', 'field1', ['min' => 7]],
            'value_greater_than_max' => ['AbcDef', 'field2', ['max' => 5]],
            'value_met_only_min' => ['abcdef', 'field3', ['min' => 6, 'max' => 5]],
            'value_met_only_max' => ['abcdef', 'field4', ['min' => 7, 'max' => 6]]
        ];
    }
}

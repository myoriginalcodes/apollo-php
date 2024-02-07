<?php

declare(strict_types=1);

namespace Tests\Unit;

use MyOriginalCodes\ApolloPhp\Validator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private Validator $validator;

    public function setUp(): void
    {
        $this->validator = new Validator();
    }

    #[Test]
    public function shouldReturnValidatorInstanceWhenNoRulesOrValuesAreSet(): void
    {
        $instance = $this->validator->validate();

        $this->assertInstanceOf(Validator::class, $instance);
    }
}

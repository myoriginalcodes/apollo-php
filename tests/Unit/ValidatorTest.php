<?php

declare(strict_types=1);

namespace Tests\Unit;

use MyOriginalCodes\ApolloPhp\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private Validator $validator;

    public function setUp(): void
    {
        $this->validator = new Validator([
            'field1' => [
                'only_letters' => ['bla'],
            ]
        ]);
    }

    public function testMethodCall(): void
    {
        $this->validator->validate();
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature;

use MyOriginalCodes\ApolloPhp\Validator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ValidateRequiredTest extends TestCase
{
    private Validator $validator;

    public function setUp(): void
    {
        $this->validator = new Validator;
    }

    #[Test]
    public function shouldAskForRequiredParameter(): void
    {
        $this->validator->setRules([
            'field' => ['required']
        ]);

        $this->validator->validate();

        $this->assertArrayHasKey('field', $this->validator->getErrorsBag());
    }
}

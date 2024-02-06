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
                'only_letters',
                'not_empty',
            ],
            'field2' => [
                'length' => [
                    'max' => 10
                ],
                'only_numbers'
            ],
            'field3' => [
                'not_empty'
            ],
            'field4' => [
                'required'
            ]
        ]);

        $this->validator->setValues([
            'field1' => 'AbcDef123',
            'field2' => 'AbcDefFghAbcDDDEEEFFF',
        ]);
    }

    public function testMethodCall(): void
    {
        $this->validator->validate();

        print_r($this->validator->getErrorsBag());
    }
}

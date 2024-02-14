<?php

declare(strict_types=1);

use MyOriginalCodes\ApolloPhp\Validator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ValidateOnlyLettersTest extends TestCase
{
    private Validator $validator;

    public function setUp(): void
    {
        $this->validator = new Validator;
    }

    #[Test]
    public function shouldAcceptsOnlyLetters(): void
    {
        $this->validator->setRules([
            'field' => [
                'only_letters'
            ]
        ]);
        $this->validator->setValues([
            'field' => 'abcd'
        ]);
        $this->validator->validate();

        $this->assertEmpty($this->validator->getErrorsBag());
    }

    #[Test]
    public function shouldNotAcceptValueWithSpaces(): void
    {
        $this->validator->setRules([
            'field' => [
                'only_letters'
            ]
        ]);
        $this->validator->setValues([
            'field' => 'abcd abcd'
        ]);
        $this->validator->validate();

        $this->assertArrayHasKey('field', $this->validator->getErrorsBag());
    }

    #[Test]
    public function shouldAcceptValueWithSpacesWhenAllowSpacesIsSetToTrue(): void
    {   
        $this->validator->setRules([
            'field' => [
                'only_letters' => [
                    'allow_spaces' => true
                ]
            ]
        ]);
        $this->validator->setValues([
            'field' => 'abcd abcd'
        ]);
        $this->validator->validate();

        $this->assertEmpty($this->validator->getErrorsBag());
    }

    #[Test]
    public function shouldWorkCallingAliasOrOriginalMethod(): void
    {
        $alias = "only_letters";
        $original = "onlyLetters";

        $this->validator->setRules([
            'field_alias' => [
                $alias
            ]
        ]);
        $this->validator->setValues([
            'field_alias' => 'abcd abcd'
        ]);
        $this->validator->validate();

        $this->assertArrayHasKey('field_alias', $this->validator->getErrorsBag());

        $this->validator->setRules([
            'field_original' => [
                $original
            ]
        ]);
        $this->validator->setValues([
            'field_original' => 'abcd abcd'
        ]);
        $this->validator->validate();

        $this->assertArrayHasKey('field_original', $this->validator->getErrorsBag());
    }
}

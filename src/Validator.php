<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp;

use MyOriginalCodes\ApolloPhp\Exceptions\ValidatorNotFoundException;
use MyOriginalCodes\ApolloPhp\Validators\Length;
use MyOriginalCodes\ApolloPhp\Validators\NotEmpty;
use MyOriginalCodes\ApolloPhp\Validators\OnlyLetters;
use MyOriginalCodes\ApolloPhp\Validators\OnlyNumbers;
use MyOriginalCodes\ApolloPhp\Validators\Required;

class Validator
{
    use Length;
    use NotEmpty;
    use OnlyLetters;
    use OnlyNumbers;
    use Required;

    private const MUST_CHECK_VALIDATORS = ['required'];

    private static bool $throwExceptions = false;

    private static array $errorsBag = [];

    public function __construct(
        public array $rules = [],
        public array $values = []
    ){}

    public function setValues(array $values): void
    {   
        $this->values = $values;
    }

    public function setRules(array $rules): void
    {   
        $this->rules = $rules;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function getErrorsBag(): array
    {
        return self::$errorsBag;
    }

    public function getExceptionsBehavior(): bool
    {
        return self::$throwExceptions;
    }

    public function validate(bool $throwExceptions = false): Validator
    {   
        if(0 === count($this->rules) && 0 === count($this->values)){
            return $this;   
        }

        self::$throwExceptions = $throwExceptions;
        
        foreach($this->rules as $field => $validators){
            if(is_array($validators)){
                foreach($validators as $validator => $args){
                
                    $validatorMethod = is_numeric($validator) ? $args : $validator;
    
                    if(!method_exists($this, $validatorMethod)){
                        throw new ValidatorNotFoundException($validatorMethod);
                    }
                    if(array_key_exists($field, $this->values) || in_array($validatorMethod, self::MUST_CHECK_VALIDATORS)){
                        $fieldValue = array_key_exists($field, $this->values) ? $this->values[$field] : null;
                        $this->$validatorMethod($fieldValue, $field, $args);
                    }
                }
            }
        }
        return $this;
    }
}

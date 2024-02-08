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

    public function setValues(array $values): Validator
    {   
        $this->values = $values;
        
        return $this;
    }

    public function setRules(array $rules): Validator
    {   
        $this->rules = $rules;
        
        return $this;
    }

    public function getErrorsBag(): array
    {
        return self::$errorsBag;
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
                
                    $validatorMethod = $this->getValidatorMethod($validator, $args);
    
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

    private function getValidatorMethod(mixed $validator, mixed $args): string
    {
        $validatorMethod = is_numeric($validator) ? $args : $validator;
        return strtolower($validatorMethod);
    }
}

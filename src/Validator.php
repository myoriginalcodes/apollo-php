<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp;

use BadMethodCallException;
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
        if(0 === $this->rules){
            return $this->buildDataToReturn();   
        }

        self::$throwExceptions = $throwExceptions;
        
        foreach($this->rules as $field => $validators){
            foreach($validators as $validator => $args){ 
                
                $validatorMethod = $this->getValidatorMethod($validator, $args);

                if(!method_exists($this, $validatorMethod)){
                    throw new BadMethodCallException(
                        sprintf("The validator %s does not exists.", $validatorMethod)
                    );
                }
                
                if(array_key_exists($field, $this->values) || array_key_exists($validatorMethod, self::MUST_CHECK_VALIDATORS)){
                    $this->$validatorMethod($this->values[$field], $field);
                }
            }
        }
        return $this->buildDataToReturn();
    }

    private function buildDataToReturn(): Validator
    {
        return $this;
    }

    private function getValidatorMethod(mixed $validator, mixed $args): string
    {
        $validatorMethod = is_numeric($validator) ? $args : $validator;

        return strtolower($validatorMethod);
    }
}

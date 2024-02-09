<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp;

use Exception;
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

    /** 
     * @var array<string> 
     */
    private const MUST_CHECK_VALIDATORS = ['required'];

    /** 
     * @var bool
     */
    private static bool $throwExceptions = false;

    /** 
     * @var array<string, array<string, string>>
     */
    private static array $errorsBag = [];

    public function __construct(
        /** 
         * @var array<string, array<string, mixed>>
         */
        public array $rules = [],
        
        /** 
         * @var array<string, mixed|null>
         */
        public array $values = []
    ){}
    
    /**
     * Set or modify the values that need to validated.
     * 
     * @param array <string, mixed|null> $values
     *
     * @return void
     */
    public function setValues(array $values): void
    {   
        $this->values = array_merge($this->values, $values);
    }
    
    /**
     * Set the rules for validation.
     *
     * @param array<string, array<string, mixed>> $rules
     *
     * @return void
     */
    public function setRules(array $rules): void
    {   
        $this->rules = $rules;
    }
    
    /**
     * Return the current values that will be validated.
     *
     * @return array<string, mixed|null>
     */
    public function getValues(): array
    {
        return $this->values;
    }
    
    /**
     * Return the current rules specified.
     *
     * @return array<string, array<string, mixed>>
     */
    public function getRules(): array
    {
        return $this->rules;
    }
    
    /**
     * Return all the validation's errors 
     * when the parameter $throwExceptions is set to false.
     *
     * @return array<string, array<string, string>>
     */
    public function getErrorsBag(): array
    {
        return self::$errorsBag;
    }

    /**
     * Return the exceptions behavior if set to true 
     * the method will thown all exceptions.
     *
     * @return bool
     */
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

                    if(!is_string($validatorMethod)){
                        throw new Exception(
                            sprintf(
                                "Parameter %s provided for the validator name is invalid. Tha validator name must be a string.",
                                print_r($validatorMethod, true)
                            ));
                    }
                    $validatorMethod = (string) $validatorMethod;

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

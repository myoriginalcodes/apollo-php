<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp;

use BadMethodCallException;
use MyOriginalCodes\ApolloPhp\Validators\OnlyLetters;

class Validator
{
    use OnlyLetters;

    private array $values;

    public function __construct(
        public array $rules = [],
        public bool $errors = false,
        public readonly array $errorsBag = []
    ){}

    public function setValues(array $values): Validator
    {
        $this->values = $values;
        
        return $this;
    }

    public function validate(): ?array
    {
        if(0 === $this->rules){
            return $this->buildDataToReturn();   
        }

        foreach($this->rules as $field => $validators){
            foreach($validators as $validator => $args){
                if(!method_exists($this, $validator)){
                    throw new BadMethodCallException(
                        sprintf("The validator %s does no exists.", $validator)
                    );
                }
            }
            $this->$validator($args);
        }

        return $this->buildDataToReturn();
    }

    private function buildDataToReturn(): ?array
    {
        if(true === $this->errors){
            return $this->errorsBag;
        }
        return null;
    }
}

<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\InvalidParameterForValidatorException;
use MyOriginalCodes\ApolloPhp\Exceptions\LengthException;

trait Length
{
    private bool $minLengthIsInvalid;

    private bool $maxLengthIsInvalid;

    private mixed $minLength;

    private mixed $maxLength;

    public function length(string $value, string $bagKey, array $args): void
    {   
        $this->runPipelineForValidation($value, $args);

        if(true === $this->minLengthIsInvalid || true === $this->maxLengthIsInvalid){
            if(true === static::class::$throwExceptions){
                throw new LengthException($value, $bagKey, (string)$this->minLength, (string)$this->maxLength);
            }
            static::class::$errorsBag[$bagKey]['length'] = sprintf(LengthException::MESSAGE, $value, $bagKey, (string)$this->minLength, (string)$this->maxLength);
        }
    }

    private function runPipelineForValidation(string $value, array $args): void
    {
        $this->initProperties();
        $this->getArgs($args);
        $this->validateMinLength($value);
        $this->validateMaxLength($value);
    }

    private function initProperties(): void
    {
        $this->minLengthIsInvalid = false;
        $this->maxLengthIsInvalid = false;
        $this->minLength = null;
        $this->maxLength = null;
    }

    private function getArgs(array $args): void
    {
        foreach($args as $arg => $value){
            if('min' === $arg || 'minLength' === $arg){
                $this->minLength = is_numeric($value) ? $value : throw new InvalidParameterForValidatorException($value, $arg);
            }

            if('max' === $arg || 'maxLength' === $arg){
                $this->maxLength = is_numeric($value) ? $value : throw new InvalidParameterForValidatorException($value, $arg);
            }
        }
    }

    private function validateMinLength(string $value): void
    {
        if(null === $this->minLength){
            return;
        }
        $this->minLengthIsInvalid = ($this->minLength > strlen($value));
    }

    private function validateMaxLength(string $value): void
    {
        if(null === $this->maxLength){
            return;
        }
        $this->maxLengthIsInvalid = $this->maxLength < strlen($value);
    }
}

<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\OnlyLettersException;

trait OnlyLetters
{
    private string $defaultRegularExpression = "/[A-Za-z]/";

    public function only_letters(string $value, mixed $bagKey, mixed $args = null): void
    {
        $this->onlyLetters($value, $bagKey, $args);
    }

    public function onlyLetters(string $value, mixed $bagKey, mixed $args = null): void
    {
        $regularExpression = $this->getRegularExpression($args);

        if(0 < strlen(preg_replace($regularExpression, "", $value))){
            if(true === static::class::$throwExceptions){
                throw new OnlyLettersException($value, $bagKey);
            }
            static::class::$errorsBag[$bagKey]['only_letters'] = sprintf(OnlyLettersException::MESSAGE, $value, $bagKey);
        }
    }

    private function getRegularExpression(mixed $args): string
    {   
        if(!is_array($args)){
            return $this->defaultRegularExpression;
        }
        
        foreach($args as $setting => $value){
            if('allow_spaces' === $setting){
                if(true === $value){
                    return "/^[a-zA-Z\s]*$/";
                }
            }
        }

        return $this->defaultRegularExpression;
    }
}

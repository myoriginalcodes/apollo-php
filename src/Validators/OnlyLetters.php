<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\OnlyLettersException;

trait OnlyLetters
{
    public function only_letters(string $value, mixed $bagKey, array $args = []): void
    {
        $this->onlyLetters($value, $bagKey, $args);
    }

    public function onlyLetters(string $value, mixed $bagKey, array $args = []): void
    {
        $regularExpression = $this->getRegularExpression($args);

        if(0 < strlen(preg_replace($regularExpression, "", $value))){
            if(true === static::class::$throwExceptions){
                throw new OnlyLettersException($value, $bagKey);
            }
            static::class::$errorsBag[$bagKey]['only_letters'] = sprintf(OnlyLettersException::MESSAGE, $value, $bagKey);
        }
    }

    private function getRegularExpression(array $args): string
    {
        foreach($args as $arg => $value){
            if('allow_spaces' === $arg){ 
                if(true === $value){
                    return "/^[a-zA-Z\s]*$/";
                }
            }
        }

        return "/[A-Za-z]/";
    }
}

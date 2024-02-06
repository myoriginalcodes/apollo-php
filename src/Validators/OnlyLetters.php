<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\OnlyLettersException;

trait OnlyLetters
{
    public function only_letters(string $value, mixed $bagKey): void
    {
        $this->onlyLetters($value, $bagKey);
    }

    public function onlyLetters(string $value, mixed $bagKey): void
    {
        if(0 < strlen(preg_replace("/[A-Za-z]/", "", $value))){
            if(true === static::class::$throwExceptions){
                throw new OnlyLettersException($value, $bagKey);
            }
            static::class::$errorsBag[$bagKey]['only_letters'] = sprintf(OnlyLettersException::MESSAGE, $value, $bagKey);
        }
    }
}

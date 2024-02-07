<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\OnlyNumbersException;

trait OnlyNumbers
{
    public function only_numbers(string $value, string $bagKey): void
    {
        $this->onlyNumbers($value, $bagKey);
    }

    public function onlyNumbers(string $value, string $bagKey): void
    {
        if(0 < strlen(preg_replace("/[0-9]/", "", $value))){
            if(!is_numeric(str_replace([',', '.'], '', $value))){
                if(true === static::class::$throwExceptions){
                    throw new OnlyNumbersException($value, $bagKey);
                }
                static::class::$errorsBag[$bagKey]['only_numbers'] = sprintf(OnlyNumbersException::MESSAGE, $value, $bagKey);
            }
        }
    }
}

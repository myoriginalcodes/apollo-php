<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\NotEmptyException;

trait NotEmpty
{
    public function not_empty(mixed $value, string $bagKey): void
    {
        $this->notEmpty($value, $bagKey);
    }

    public function notEmpty(mixed $value, string $bagKey): void
    {
        if(empty($value)){
            if(true === static::class::$throwExceptions){
                throw new NotEmptyException($value, $bagKey);
            }
            static::class::$errorsBag[$bagKey]['not_empty'] = sprintf(NotEmptyException::MESSAGE, print_r($value, true), $bagKey);
        }
    }
}

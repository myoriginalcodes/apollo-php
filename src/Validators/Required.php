<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

use MyOriginalCodes\ApolloPhp\Exceptions\RequiredException;

trait Required
{
    public function required(mixed $value, string $bagKey): void
    {
        if(null === $value){
            if(true === static::class::$throwExceptions){
                throw new RequiredException($value, $bagKey);
            }
            static::class::$errorsBag[$bagKey]['not_empty'] = sprintf(RequiredException::MESSAGE, $bagKey);
        }
    }
}

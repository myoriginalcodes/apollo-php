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
                throw new RequiredException($bagKey);
            }
            static::class::$errorsBag[$bagKey]['required'] = sprintf(RequiredException::MESSAGE, $bagKey);
        }
    }
}

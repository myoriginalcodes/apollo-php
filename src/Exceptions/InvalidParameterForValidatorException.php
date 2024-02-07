<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Exceptions;

use Exception;

class InvalidParameterForValidatorException extends Exception
{
    public const MESSAGE = "Parameter %s provided for validator %s is invalid. %s.";

    public function __construct(mixed $parameter, mixed $validator, string $helpMessage = "Please check the documentation")
    {
        parent::__construct(
            sprintf(self::MESSAGE, $parameter, $validator, $helpMessage)
        );
    }
}

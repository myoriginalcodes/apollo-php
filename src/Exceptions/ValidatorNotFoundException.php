<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Exceptions;

use Exception;

class ValidatorNotFoundException extends Exception
{
    public const MESSAGE = "The validator %s was not found. Please check the documentation.";

    public function __construct(string $value)
    {
        parent::__construct(
            sprintf(self::MESSAGE, $value)
        );
    }
}

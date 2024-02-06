<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Exceptions;

use Exception;

class OnlyLettersException extends Exception
{
    public const MESSAGE = "Value %s is invalid. You can use just letters [A-Za-z] for %s.";

    public function __construct(mixed $value, mixed $target)
    {
        parent::__construct(
            sprintf(self::MESSAGE, $value, $target)
        );
    }
}

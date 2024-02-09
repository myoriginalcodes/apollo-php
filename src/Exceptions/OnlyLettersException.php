<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Exceptions;

use Exception;

class OnlyLettersException extends Exception
{
    public const MESSAGE = "Value %s provided for %s is invalid. You can use only letters [A-Za-z].";

    public function __construct(string $value, string $target)
    {
        parent::__construct(
            sprintf(self::MESSAGE, $value, $target)
        );
    }
}

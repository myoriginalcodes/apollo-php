<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Exceptions;

use Exception;

class OnlyNumbersException extends Exception
{
    public const MESSAGE = "Value %s provided for %s is invalid. You can use only numbers [0-9].";

    public function __construct(mixed $value, mixed $target)
    {
        parent::__construct(
            sprintf(self::MESSAGE, $value, $target)
        );
    }
}

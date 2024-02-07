<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Exceptions;

use Exception;

class NotEmptyException extends Exception
{
    public const MESSAGE = "Value %s provided for %s is invalid. It can't be empty.";

    public function __construct(mixed $value, mixed $target)
    {
        parent::__construct(
            sprintf(self::MESSAGE, print_r($value, true), $target)
        );
    }
}

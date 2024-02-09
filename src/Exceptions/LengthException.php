<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Exceptions;

use Exception;

class LengthException extends Exception
{
    public const MESSAGE = "Value %s provided for %s is invalid. It must met the criterias [min: %s, max: %s].";

    public function __construct(string $value, string $target, string $min, string $max)
    {
        parent::__construct(
            sprintf(self::MESSAGE, $value, $target, $min, $max)
        );
    }
}

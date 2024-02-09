<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Exceptions;

use Exception;

class RequiredException extends Exception
{
    public const MESSAGE = "A value for %s is required. You must provide a value for it.";

    public function __construct(string $target)
    {
        parent::__construct(
            sprintf(self::MESSAGE, $target)
        );
    }
}

<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

trait NotEmpty
{
    public function not_empty(string $value): ?array
    {
        return $this->notEmpty($value);
    }

    public function notEmpty(string $value): ?array
    {
        echo "======yes========".PHP_EOL;

        return [];
    }
}

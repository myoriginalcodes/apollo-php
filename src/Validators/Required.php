<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

trait Required
{
    public function Required(string $value): ?array
    {
        echo "======yes========".PHP_EOL;

        return [];
    }
}

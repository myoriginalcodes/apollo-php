<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

trait OnlyNumbers
{
    public function only_numbers(string $value): ?array
    {
        return $this->onlyNumbers($value);
    }

    public function onlyNumbers(string $value): ?array
    {
        echo "======yes========".PHP_EOL;

        return [];
    }
}

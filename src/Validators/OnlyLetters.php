<?php

declare(strict_types=1);

namespace MyOriginalCodes\ApolloPhp\Validators;

trait OnlyLetters
{
    private string $exceptionMessage = "You can use just letters [A-Za-z].";

    public function only_letters(array $rules): ?array
    {
        return $this->onlyLetters($rules);
    }

    public function onlyLetters(array $rules): ?array
    {
        echo "======yes========".PHP_EOL;

        return [];
    }
}

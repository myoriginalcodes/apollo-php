<?php

declare(strict_types=1);

namespace Tests\Unit\Validators;

use PHPUnit\Framework\TestCase;

class OnlyLettersTest extends TestCase
{
    public function testTrue(): void
    {
        $this->assertTrue(true);
    }
}

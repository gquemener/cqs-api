<?php

declare (strict_types = 1);

namespace App\Authentication\Domain;

final class TokenValue
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }
}

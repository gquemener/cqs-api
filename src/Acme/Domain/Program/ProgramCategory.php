<?php

declare(strict_types=1);

namespace App\Acme\Domain\Program;

final class ProgramCategory
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}

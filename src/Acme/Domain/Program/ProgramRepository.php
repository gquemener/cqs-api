<?php

declare (strict_types = 1);

namespace App\Acme\Domain\Program;

interface ProgramRepository
{
    public function all(): array;
}

<?php

declare (strict_types = 1);

namespace App\Acme\Domain\Program;

interface ProgramRepository
{
    public function get(ProgramId $programId): ?Program;

    public function findAll(): array;

    public function add(Program $program): void;

    public function update(Program $program): void;
}

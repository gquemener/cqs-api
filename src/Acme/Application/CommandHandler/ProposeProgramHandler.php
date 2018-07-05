<?php

declare(strict_types=1);

namespace App\Acme\Application\CommandHandler;

use App\Acme\Domain\Program as Domain;
use App\Acme\Application\Command\ProposeProgram;

final class ProposeProgramHandler
{
    public function __construct(Domain\ProgramRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ProposeProgram $command): void
    {
        $program = Domain\Program::propose(
            $command->programId(),
            $command->description(),
            $command->maxParticipants()
        );

        $this->repository->add($program);
    }
}

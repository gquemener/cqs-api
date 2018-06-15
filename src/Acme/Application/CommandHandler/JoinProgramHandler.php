<?php

declare (strict_types = 1);

namespace App\Acme\Application\CommandHandler;

use App\Acme\Application\Command\JoinProgram;
use App\Acme\Domain;

final class JoinProgramHandler
{
    public function __construct(
        Domain\Program\ProgramRepository $programRepository,
        Domain\User\UserRepository $userRepository
    ) {
        $this->programRepository = $programRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(JoinProgram $command): void
    {
        if (null === $user = $this->userRepository->get($command->userId())) {
            throw new \RuntimeException(sprintf('User "%s" not found', $command->userId()));
        }

        if (null === $program = $this->programRepository->get($command->programId())) {
            throw new \RuntimeException('Program not found');
        }

        $program->addParticipant(
            $user->id()
        );

        $this->programRepository->update($program);
    }
}

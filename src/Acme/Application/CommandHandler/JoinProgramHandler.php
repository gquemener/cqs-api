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
        $userId = Domain\User\UserId::fromString($command->userId());
        if (null === $user = $this->userRepository->get($userId)) {
            throw new \RuntimeException(sprintf('User "%s" not found', $command->userId()));
        }

        $programId = Domain\Program\ProgramId::fromString($command->programId());
        if (null === $program = $this->programRepository->get($programId)) {
            throw new \RuntimeException(sprintf('Program "%s" not found', $command->programId()));
        }

        $program->addParticipant(
            $user->id(),
            \DateTimeImmutable::createFromFormat(
                \DateTime::ISO8601,
                $command->date()
            )
        );

        $this->programRepository->update($program);
    }
}

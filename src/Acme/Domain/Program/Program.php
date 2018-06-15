<?php

declare(strict_types=1);

namespace App\Acme\Domain\Program;

use App\Acme\Domain\User\User;
use App\Acme\Domain\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Program
{
    private $id;
    private $description;
    private $maxParticipants;
    private $participants;

    private function __construct(ProgramId $id, string $description, int $maxParticipants)
    {
        $this->id = $id->toString();
        $this->description = $description;
        $this->maxParticipants = $maxParticipants;
        $this->participants = new ArrayCollection();
    }

    public function id(): ProgramId
    {
        return ProgramId::fromString($this->id);
    }

    public function description(): string
    {
        return $this->description;
    }

    public function maxParticipants(): int
    {
        return $this->maxParticipants;
    }

    public function participants(): array
    {
        return $this->participants->toArray();
    }

    public static function propose(ProgramId $programId, string $description, int $maxParticipants)
    {
        return new self($programId, $description, $maxParticipants);
    }

    public function addParticipant(UserId $userId): void
    {
        $participant = new Participant($this, $userId);
        $this->participants->add($participant);
        return;

        if ($this->participants->contains($participant)) {
            throw new \RuntimeException(sprintf('User "%s" is already participating to this program', $user->userId()));
        }

        if (count($this->participants) >= $this->maxParticipants) {
            throw new \RuntimeException(sprintf('Program "%s" is full', $this->programId()));
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Acme\Domain\Program;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\DomainEvent;
use App\Acme\Domain\Program\Events;
use App\Acme\Domain\User\User;
use App\Acme\Domain\User\UserId;

final class Program implements DomainEvent\Provider, \JsonSerializable
{
    use DomainEvent\RecordEvents;

    private $id;
    private $description;
    private $maxParticipants;
    private $participants;
    private $createdAt;

    private function __construct(ProgramId $id, string $description, int $maxParticipants)
    {
        $this->id = $id->toString();
        $this->description = $description;
        $this->maxParticipants = $maxParticipants;
        $this->participants = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
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
        $self = new self($programId, $description, $maxParticipants);
        $self->record(new Events\ProgramWasProposed([
            'id' => $self->id,
            'description' => $self->description,
            'max_partipants' => $self->maxParticipants,
        ]));

        return $self;
    }

    public function addParticipant(UserId $userId, \DateTimeImmutable $at): void
    {
        $participant = new Participant($this, $userId, $at);

        if ($this->participants->contains($participant)) {
            throw new \RuntimeException(sprintf('User "%s" is already participating to this program', $user->id()));
        }

        if (count($this->participants) >= $this->maxParticipants) {
            throw new \RuntimeException(sprintf('Program "%s" is full', $this->id()));
        }

        $this->participants->add($participant);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'description' => $this->description(),
            'maxParticipants' => $this->maxParticipants(),
            'createdAt' => $this->createdAt,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Acme\Domain\Program;

use App\Acme\Domain\User\UserId;

final class Participant implements \JsonSerializable
{
    private $id;
    private $program;
    private $userId;
    private $at;

    public function __construct(Program $program, UserId $userId, \DateTimeImmutable $at)
    {
        $this->program = $program;
        $this->userId = $userId->toString();
        $this->at = $at;
    }

    public function program(): Program
    {
        return $this->program;
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->userId);
    }

    public function at(): \DateTimeImmutable
    {
        return $this->at;
    }

    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId()->toString(),
            'at' => $this->at,
        ];
    }
}

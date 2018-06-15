<?php

declare(strict_types=1);

namespace App\Acme\Domain\Program;

use App\Acme\Domain\User\UserId;

final class Participant
{
    private $id;
    private $program;
    private $userId;

    public function __construct(Program $program, UserId $userId)
    {
        $this->program = $program;
        $this->userId = $userId->toString();
    }

    public function program(): Program
    {
        return $this->program;
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->userId);
    }
}

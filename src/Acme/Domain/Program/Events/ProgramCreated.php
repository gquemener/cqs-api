<?php

declare (strict_types = 1);

namespace App\Acme\Domain\Program\Events;

use App\DomainEvent\Event;
use App\Acme\Domain\Program\ProgramId;

final class ProgramCreated extends Event
{
    public function id(): ProgramId
    {
        return ProgramId::fromString($this->payload()['id']);
    }
}

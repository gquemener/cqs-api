<?php

declare (strict_types = 1);

namespace App\DomainEvent;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

class Event extends BaseEvent
{
    private $payload;

    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    public function name(): string
    {
        return get_class($this);
    }

    public function payload(): array
    {
        return $this->payload;
    }
}

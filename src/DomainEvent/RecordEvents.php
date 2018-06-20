<?php

declare (strict_types = 1);

namespace App\DomainEvent;

trait RecordEvents
{
    private $events = [];

    public function record(Event $event): void
    {
        $this->events[] = $event;
    }

    public function popEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}

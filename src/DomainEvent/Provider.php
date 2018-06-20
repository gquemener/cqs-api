<?php

declare (strict_types = 1);

namespace App\DomainEvent;

interface Provider
{
    public function record(Event $event): void;

    public function popEvents(): array;
}

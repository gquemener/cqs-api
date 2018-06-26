<?php

declare (strict_types = 1);

namespace App\Acme\Domain\Client\Events;

use App\DomainEvent\Event;
use App\Acme\Domain\Client\ClientId;

final class ClientHasRegistered extends Event
{
    public function clientId(): ClientId
    {
        return ClientId::fromString($this->payload()['id']);
    }

    public function login(): string
    {
        return $this->payload()['login'];
    }

    public function password(): string
    {
        return $this->payload()['password'];
    }
}

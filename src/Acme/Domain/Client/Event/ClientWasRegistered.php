<?php

declare(strict_types=1);

namespace App\Acme\Domain\Client\Event;

use Prooph\EventSourcing\AggregateChanged;

final class ClientWasRegistered extends AggregateChanged
{
    public function name(): string
    {
        return $this->payload()['name'];
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

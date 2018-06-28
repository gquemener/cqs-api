<?php

declare (strict_types = 1);

namespace App\DomainEvent;

use Prooph\Common\Messaging\HasMessageName;

class Event implements HasMessageName
{
    private $payload;

    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    public function messageName(): string
    {
        return get_class($this);
    }

    public function payload(): array
    {
        return $this->payload;
    }
}

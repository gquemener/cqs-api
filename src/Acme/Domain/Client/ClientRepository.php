<?php

declare (strict_types = 1);

namespace App\Acme\Domain\Client;

interface ClientRepository
{
    public function add(Client $client): void;

    public function get(ClientId $clientId): ?Client;
}

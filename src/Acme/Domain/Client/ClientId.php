<?php

declare(strict_types=1);

namespace App\Acme\Domain\Client;

final class ClientId
{
    private $uuid;

    public static function generate(): ClientId
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4());
    }

    public static function fromString(string $clientId): ClientId
    {
        return new self(\Ramsey\Uuid\Uuid::fromString($clientId));
    }

    private function __construct(\Ramsey\Uuid\UuidInterface $clientId)
    {
        $this->uuid = $clientId;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(ClientId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}

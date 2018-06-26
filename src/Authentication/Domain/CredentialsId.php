<?php

declare(strict_types=1);

namespace App\Authentication\Domain;

final class CredentialsId
{
    private $uuid;

    public static function generate(): CredentialsId
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4());
    }

    public static function fromString(string $clientId): CredentialsId
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

    public function equals(CredentialsId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}

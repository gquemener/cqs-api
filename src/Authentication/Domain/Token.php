<?php

declare (strict_types = 1);

namespace App\Authentication\Domain;

use App\Acme\Domain\Client\ClientId;

final class Token
{
    private $ownerId;
    private $value;
    private $expiresAt;

    public function __construct(string $ownerId, TokenValue $value, int $ttl)
    {
        $this->ownerId = $ownerId;
        $this->value = $value->toString();
        $this->expiresAt = new \DateTimeImmutable(sprintf('+ %d seconds', $ttl), new \DateTimeZone('UTC'));
    }

    public function ownerId(): string
    {
        return $this->ownerId;
    }

    public function value(): TokenValue
    {
        return new TokenValue($this->value);
    }

    public function expiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }
}

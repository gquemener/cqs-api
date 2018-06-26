<?php

declare(strict_types=1);

namespace App\Acme\Domain\Program;

final class ProgramId
{
    private $uuid;

    public static function generate(): ProgramId
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4());
    }

    public static function fromString(string $programId): ProgramId
    {
        return new self(\Ramsey\Uuid\Uuid::fromString($programId));
    }

    private function __construct(\Ramsey\Uuid\UuidInterface $programId)
    {
        $this->uuid = $programId;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(ProgramId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}

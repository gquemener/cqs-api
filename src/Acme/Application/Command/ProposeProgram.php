<?php

declare(strict_types=1);

namespace App\Acme\Application\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Acme\Domain\Program as Domain;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

final class ProposeProgram extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function withDescription(string $description, int $maxParticipants, string $programId): self
    {
        return new self([
            'program_id' => $programId,
            'description' => $description,
            'max_participants' => $maxParticipants,
        ]);
    }

    public function programId(): Domain\ProgramId
    {
        return Domain\ProgramId::fromString($this->payload['program_id']);
    }

    public function description(): string
    {
        return $this->payload['description'];
    }

    public function maxParticipants(): int
    {
        return $this->payload['max_participants'];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addGetterMethodConstraint('description', 'description', new Assert\NotBlank());
        $metadata->addGetterMethodConstraint('maxParticipants', 'maxParticipants', new Assert\GreaterThan(0));
    }
}

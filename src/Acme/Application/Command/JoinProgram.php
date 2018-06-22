<?php

declare (strict_types = 1);

namespace App\Acme\Application\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Acme\Domain\Program\ProgramId;
use App\Acme\Domain\User\UserId;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

final class JoinProgram extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function create(string $userId, string $programId, string $date): self
    {
        return new self([
            'user_id' => $userId,
            'program_id' => $programId,
            'date' => $date,
        ]);
    }

    public function programId(): string
    {
        return $this->payload['program_id'];
    }

    public function userId(): string
    {
        return $this->payload['user_id'];
    }

    public function date(): string
    {
        return $this->payload['date'];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addGetterMethodConstraints('userId', 'userId', [new Assert\NotBlank(), new Assert\Uuid()]);
        $metadata->addGetterMethodConstraints('programId', 'programId', [new Assert\NotBlank(), new Assert\Uuid()]);
        $metadata->addGetterMethodConstraints('date', 'date', [
            new Assert\NotBlank(),
            new Assert\Regex(['pattern' => '/\+0000$/', 'message' => 'This date is not in the UTC timezone']),
            new Assert\DateTime(['format' => \DateTime::ISO8601])
        ]);
    }
}

<?php

declare (strict_types = 1);

namespace App\Acme\Application\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Acme\Domain\Program\ProgramId;
use App\Acme\Domain\User\UserId;

final class JoinProgram extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function create(string $userId, string $programId): self
    {
        return new self([
            'user_id' => $userId,
            'program_id' => $programId,
        ]);
    }

    public function programId(): ProgramId
    {
        return ProgramId::fromString($this->payload['program_id']);
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->payload['user_id']);
    }
}

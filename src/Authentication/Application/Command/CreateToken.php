<?php

declare (strict_types = 1);

namespace App\Authentication\Application\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateToken extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function assignTo(string $ownerId): self
    {
        return new self([
            'owner_id' => $ownerId,
        ]);
    }

    public function ownerId(): string
    {
        return $this->payload['owner_id'];
    }
}

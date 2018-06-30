<?php

declare (strict_types = 1);

namespace App\Authentication\Domain\Events;

use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Authentication\Domain\Credentials;

final class CredentialsCreationFailed extends DomainEvent implements PayloadConstructable
{
    use PayloadTrait;

    public static function withCredentials(Credentials $credentials): self
    {
        return new self([
            'owner_id' => $credentials->ownerId(),
        ]);
    }

    public function ownerId(): string
    {
        return $this->payload()['owner_id'];
    }
}

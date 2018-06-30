<?php

declare (strict_types = 1);

namespace App\Acme\Application\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

final class RemoveClient extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function withId(string $clientId): self
    {
        return new self([
            'client_id' => $clientId,
        ]);
    }

    public function clientId(): string
    {
        return $this->payload['client_id'];
    }
}

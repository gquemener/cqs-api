<?php

declare (strict_types = 1);

namespace App\Authentication\Application\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

final class CreateCredentials extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function with(string $ownerId, string $login, string $password)
    {
        return new self([
            'owner_id' => $ownerId,
            'login' => $login,
            'password' => $password,
        ]);
    }

    public function ownerId(): string
    {
        return $this->payload['owner_id'];
    }

    public function login(): string
    {
        return $this->payload['login'];
    }

    public function password(): string
    {
        return $this->payload['password'];
    }
}

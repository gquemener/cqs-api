<?php

declare (strict_types = 1);

namespace App\Authentication\Domain;

final class Credentials
{
    private $ownerId;
    private $login;
    private $password;

    public function __construct(string $ownerId, string $login, string $password)
    {
        $this->ownerId = $ownerId;
        $this->login = $login;
        $this->password = $password;
    }

    public function ownerId(): string
    {
        return $this->ownerId;
    }

    public function login(): string
    {
        return $this->login;
    }

    public function password(): string
    {
        return $this->password;
    }
}

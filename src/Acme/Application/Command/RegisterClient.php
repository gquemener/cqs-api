<?php

declare (strict_types = 1);

namespace App\Acme\Application\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterClient extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function create(string $clientId, string $name, string $login, string $password): self
    {
        return new self([
            'client_id' => $clientId,
            'name' => $name,
            'login' => $login,
            'password' => $password,
        ]);
    }

    public function clientId(): string
    {
        return $this->payload['client_id'];
    }

    public function name(): string
    {
        return $this->payload['name'];
    }

    public function login(): string
    {
        return $this->payload['login'];
    }

    public function password(): string
    {
        return $this->payload['password'];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addGetterMethodConstraint('clientId', 'clientId', new Assert\NotBlank());
        $metadata->addGetterMethodConstraint('name', 'name', new Assert\NotBlank());
        $metadata->addGetterMethodConstraint('login', 'login', new Assert\NotBlank());
        $metadata->addGetterMethodConstraint('password', 'password', new Assert\NotBlank());
    }
}

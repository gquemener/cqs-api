<?php

declare (strict_types = 1);

namespace App\Acme\Domain\Client;

use App\DomainEvent;
use App\Acme\Domain\Client\Events\ClientHasRegistered;
use Symfony\Component\Security\Core\User\UserInterface;

final class Client implements DomainEvent\Provider
{
    use DomainEvent\RecordEvents;

    private $id;
    private $name;

    private function __construct(ClientId $id, string $name)
    {
        $this->id = $id->toString();
        $this->name = $name;
    }

    public static function register(ClientId $id, string $name, string $login, string $password): self
    {
        $self = new self($id, $name, $login, $password);
        $self->record(new ClientHasRegistered([
            'id' => $id->toString(),
            'name' => $name,
            'login' => $login,
            'password' => $password,
        ]));

        return $self;
    }

    public function proposeProgram(
        ProgramType $type,
        ProgramCategory $category,
        string $name,
        string $description
    ): Program {
        return Program::propose(ProgramId::generate(), $type, $category, $name, $description);
    }
}

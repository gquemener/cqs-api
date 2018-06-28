<?php

declare (strict_types = 1);

namespace App\Authentication\Application\ProcessManager;

use App\Acme\Domain\Client\Events\ClientHasRegistered;
use App\Authentication\Application\Command\CreateToken;
use Prooph\ServiceBus\CommandBus;

final class CreateClientToken
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(ClientHasRegistered $event): void
    {
        $command = CreateToken::assignTo($event->clientId()->toString());

        $this->commandBus->dispatch($command);
    }
}

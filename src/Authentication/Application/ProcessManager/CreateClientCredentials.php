<?php

declare (strict_types = 1);

namespace App\Authentication\Application\ProcessManager;

use App\Acme\Domain\Client\Events\ClientHasRegistered;
use App\Authentication\Application\Command\CreateCredentials;
use Prooph\ServiceBus\CommandBus;

final class CreateClientCredentials
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(ClientHasRegistered $event): void
    {
        $command = CreateCredentials::with($event->clientId()->toString(), $event->login(), $event->password());

        $this->commandBus->dispatch($command);
    }
}

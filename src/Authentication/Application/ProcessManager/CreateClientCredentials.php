<?php

declare (strict_types = 1);

namespace App\Authentication\Application\ProcessManager;

use App\Acme\Domain\Client\Events\ClientHasRegistered;
use App\Authentication\Application\Command\CreateCredentials;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Exception\MessageDispatchException;
use Prooph\ServiceBus\EventBus;
use Authentication\Domain\Events\CredentialsCreationFailed;
use Prooph\ServiceBus\Exception\CommandDispatchException;

final class CreateClientCredentials
{
    private $commandBus;
    private $eventBus;

    public function __construct(
        CommandBus $commandBus,
        EventBus $eventBus
    ) {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
    }

    public function __invoke(ClientHasRegistered $event): void
    {
        $command = CreateCredentials::with($event->clientId(), $event->login(), $event->password());

        $this->commandBus->dispatch($command);
    }
}

<?php

declare(strict_types=1);

namespace App\Authentication\Application\ProcessManager;

use App\Authentication\Application\Command\CreateCredentials;
use Prooph\ServiceBus\CommandBus;
use App\Acme\Domain\Client\Event\ClientWasRegistered;

final class CreateClientCredentials
{
    private $commandBus;

    public function __construct(
        CommandBus $commandBus
    ) {
        $this->commandBus = $commandBus;
    }

    public function __invoke(ClientWasRegistered $event): void
    {
        $command = CreateCredentials::with($event->aggregateId(), $event->login(), $event->password());

        $this->commandBus->dispatch($command);
    }
}

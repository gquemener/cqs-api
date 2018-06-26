<?php

declare (strict_types = 1);

namespace App\Authentication\Application\ProcessManager;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Acme\Domain\Client\Events\ClientHasRegistered;
use Prooph\ServiceBus\CommandBus;
use App\Authentication\Application\Command\CreateToken;

final class CreateClientToken implements EventSubscriberInterface
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public static function getSubscribedEvents()
    {
        return [
            ClientHasRegistered::class => 'onClientHasRegistered',
        ];
    }

    public function onClientHasRegistered(ClientHasRegistered $event): void
    {
        $command = CreateToken::assignTo($event->clientId()->toString());

        $this->commandBus->dispatch($command);
    }
}

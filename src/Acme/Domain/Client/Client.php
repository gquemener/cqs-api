<?php

declare(strict_types=1);

namespace App\Acme\Domain\Client;

use Prooph\EventSourcing\AggregateRoot;
use Prooph\EventSourcing\AggregateChanged;

final class Client extends AggregateRoot
{
    private $id;
    private $name;

    public static function register(ClientId $id, string $name, string $login, string $password): self
    {
        $self = new self();
        $self->recordThat(Event\ClientWasRegistered::occur($id->toString(), [
            'name' => $name,
            'login' => $login,
            'password' => $password,
        ]));

        return $self;
    }

    public function whenClientWasRegistered(AggregateChanged $event): void
    {
        $this->id = $event->aggregateId();
        $this->name = $event->name();
    }

    protected function aggregateId(): string
    {
        return $this->id->toString();
    }

    protected function apply(AggregateChanged $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);
        if (!method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }
        $this->{$handler}($event);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when'.implode(array_slice(explode('\\', get_class($e)), -1));
    }
}

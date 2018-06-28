<?php

declare (strict_types = 1);

namespace App\DomainEvent\Dispatcher;

use App\DomainEvent\Provider;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Prooph\ServiceBus\EventBus;

final class Doctrine
{
    private $eventBus;

    private $entities = [];

    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $this->keepProvider($event);
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $this->keepProvider($event);
    }

    public function postUpdate(LifecycleEventArgs $event)
    {
        $this->keepProvider($event);
    }

    public function postRemove(LifecycleEventArgs $event)
    {
        $this->keepProvider($event);
    }

    public function postFlush(PostFlushEventArgs $event)
    {
        foreach ($this->entities as $entity) {
            foreach ($entity->popEvents() as $event) {
                $this->eventBus->dispatch($event);
            }
        }

        $this->entities = [];
    }

    private function keepProvider(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if (!$entity instanceof Provider || in_array($entity, $this->entities, true)) {
            return;
        }

        $this->entities[] = $entity;
    }
}

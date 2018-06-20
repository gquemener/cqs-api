<?php

declare (strict_types = 1);

namespace App\DomainEvent\Dispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\DomainEvent\Provider;
use Doctrine\ORM\Event\PostFlushEventArgs;

final class Doctrine
{
    private $dispatcher;

    private $entities = [];

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
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
                $this->dispatcher->dispatch($event->name(), $event);
            }
        }
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

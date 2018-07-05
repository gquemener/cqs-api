<?php

declare(strict_types=1);

namespace App\Prooph\DoctrineIntegration;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Prooph\ServiceBus\EventBus;
use Prooph\EventSourcing\AggregateRoot;

final class EventPublisher
{
    private $eventBus;
    private $entities;
    private $recordedEventsExtractor;

    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
        $this->entities = [];
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $this->keepAggregateRoot($event);
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $this->keepAggregateRoot($event);
    }

    public function postUpdate(LifecycleEventArgs $event)
    {
        $this->keepAggregateRoot($event);
    }

    public function postRemove(LifecycleEventArgs $event)
    {
        $this->keepAggregateRoot($event);
    }

    public function postFlush(PostFlushEventArgs $event)
    {
        foreach ($this->entities as $entity) {
            foreach ($this->extractRecordedEvents($entity) as $event) {
                $this->eventBus->dispatch($event);
            }
        }

        $this->entities = [];
    }

    private function keepAggregateRoot(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if (!$entity instanceof AggregateRoot || in_array($entity, $this->entities, true)) {
            return;
        }

        $this->entities[] = $entity;
    }

    private function extractRecordedEvents(AggregateRoot $aggregateRoot): array
    {
        if (null === $this->recordedEventsExtractor) {
            $this->recordedEventsExtractor = function (): array {
                return $this->popRecordedEvents();
            };
        }

        return $this->recordedEventsExtractor->call($aggregateRoot);
    }
}

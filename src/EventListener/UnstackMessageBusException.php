<?php

declare (strict_types = 1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Prooph\ServiceBus\Exception\MessageDispatchException;

final class UnstackMessageBusException implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 512],
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        if (!$exception instanceof MessageDispatchException) {
            return;
        }

        $previous = $exception->getPrevious();
        if ($previous instanceof \Exception) {
            $event->setException($previous);
        }
    }
}

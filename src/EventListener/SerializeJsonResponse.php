<?php

declare (strict_types = 1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Prooph\ServiceBus\Exception\MessageDispatchException;
use App\Prooph\InvalidCommandException;

final class SerializeJsonResponse implements EventSubscriberInterface
{
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => 'onKernelView',
            KernelEvents::EXCEPTION => ['onKernelException', 0],
        ];
    }

    public function onKernelView(GetResponseForControllerResultEvent $event): void
    {
        $event->setResponse(
            $this->createJsonResponse($event->getControllerResult(), 200)
        );
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();

        if ($exception instanceof InvalidCommandException) {
            $event->setResponse(
                $this->createJsonResponse($exception->violations(), 200)
            );
        }
    }

    private function createJsonResponse($data, int $statusCode): Response
    {
        if (null !== $data) {
            $data = $this->serializer->serialize($data, 'json');
        }

        return new Response(
            $data,
            null === $data ? 204 : $statusCode,
            ['Content-Type' => 'application/json']
        );
    }
}

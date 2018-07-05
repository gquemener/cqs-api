<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use App\Prooph\InvalidCommandException;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use App\Controller\View;

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
        $result = $event->getControllerResult();
        if (!$result instanceof View) {
            return;
        }

        $event->setResponse(
            $this->createJsonResponse($result->content(), $result->statusCode())
        );
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();

        if ($exception instanceof InvalidCommandException) {
            $event->setResponse(
                $this->createJsonResponse($exception->violations(), 400)
            );
        }
    }

    private function createJsonResponse($data, int $statusCode): Response
    {
        if (null !== $data) {
            $data = $this->serializer->serialize($data, 'json', [
                DateTimeNormalizer::FORMAT_KEY => \DateTime::ISO8601,
            ]);
        }

        return new Response(
            $data,
            null === $data ? 204 : $statusCode,
            ['Content-Type' => 'application/json']
        );
    }
}

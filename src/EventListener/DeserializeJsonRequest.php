<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DeserializeJsonRequest implements EventSubscriberInterface
{
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if ('json' !== $request->getContentType()) {
            return;
        }

        if (null === $body = json_decode($request->getContent(), true)) {
            $event->setResponse(new JsonResponse([
                'title' => 'Could not decode json body from the request',
                'detail' => json_last_error_msg(),
            ], 400));

            return;
        }

        if (is_array($body)) {
            $request->request->add($body);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 512],
        ];
    }
}

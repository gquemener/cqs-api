<?php

declare(strict_types=1);

namespace App\Acme\Application\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Acme\Domain\Program\Events\ProgramCreated;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class SendEmail implements EventSubscriberInterface
{
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public static function getSubscribedEvents()
    {
        return [
            ProgramCreated::class => 'onProgramCreated',
        ];
    }

    public function onProgramCreated(ProgramCreated $event): void
    {
        $this->dispatcher->addListener(KernelEvents::TERMINATE, function () {
            // Let's send mail here once the http connection has been closed (work only with fpm)
        });
    }
}

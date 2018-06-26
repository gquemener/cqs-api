<?php

declare (strict_types = 1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Acme\Domain\Client\Events\ClientHasRegistered;
use App\Security\Authentication\Token;
use App\Security\Authentication\TokenRepository;

final class DefineClientAuthenticationToken implements EventSubscriberInterface
{
    public function __construct(TokenRepository $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    public static function getSubscribedEvents()
    {
        return [
        ];
    }

    public function onClientHasRegistered(ClientHasRegistered $event): void
    {
        $token = new Token(
            $event->clientId(),
            bin2hex(random_bytes(32)),
            3600
        );

        $this->tokenStorage->add($token);
    }
}

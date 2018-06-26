<?php

declare (strict_types = 1);

namespace App\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Authentication\Domain\TokenRepository;
use App\Acme\Domain\Client\ClientRepository;
use App\Authentication\Domain\TokenValue;
use App\Acme\Domain\Client\ClientId;

final class ClientTokenUserProvider implements UserProviderInterface
{
    private $tokenRepository;
    private $clientRepository;

    public function __construct(
        TokenRepository $tokenRepository,
        ClientRepository $clientRepository
    ) {
        $this->tokenRepository = $tokenRepository;
        $this->clientRepository = $clientRepository;
    }

    public function loadUserByUsername($username)
    {
        if (null === $token = $this->tokenRepository->get(new TokenValue($username))) {
            return null;
        }

        if (null === $client = $this->clientRepository->get(ClientId::fromString($token->ownerId()))) {
            return null;
        }

        return $client;
    }

    public function refreshUser(UserInterface $user)
    {
    }

    public function supportsClass($class)
    {
    }
}

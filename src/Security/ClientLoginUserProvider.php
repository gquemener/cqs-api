<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Acme\Domain\Client\ClientRepository;

final class ClientLoginUserProvider implements UserProviderInterface
{
    private $clientRepository;

    public function __construct(
        ClientRepository $clientRepository
    ) {
        $this->clientRepository = $clientRepository;
    }

    public function loadUserByUsername($username)
    {
        if (null === $client = $this->clientRepository->getByLogin($username)) {
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

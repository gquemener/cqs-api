<?php

declare (strict_types = 1);

namespace App\Acme\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;
use App\Acme\Domain\Client as Domain;

final class DoctrineClientRepository implements Domain\ClientRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Domain\Client $client): void
    {
        $this->em->persist($client);
        $this->em->flush();
    }

    public function get(Domain\ClientId $clientId): ?Domain\Client
    {
        return $this->em->getRepository(Domain\Client::class)->find($clientId->toString());
    }

    public function getByLogin(string $login): ?Domain\Client
    {
        return $this->em->getRepository(Domain\Client::class)->findOneBy([
            'login' => $login,
        ]);
    }
}

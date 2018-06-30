<?php

declare (strict_types = 1);

namespace App\Authentication\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;
use App\Authentication\Domain;

final class DoctrineCredentialsRepository implements Domain\CredentialsRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Domain\Credentials $token): void
    {
        throw new \Exception;
        $this->em->persist($token);
        $this->em->flush();
    }

    public function get(Domain\CredentialsId $id): ?Domain\Credentials
    {
        return $this->em->getRepository(Domain\Credentials::class)->find($tokenValue->toString());
    }
}

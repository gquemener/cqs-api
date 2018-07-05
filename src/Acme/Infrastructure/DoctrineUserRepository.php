<?php

declare(strict_types=1);

namespace App\Acme\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use App\Acme\Domain\User as Domain;

final class DoctrineUserRepository implements Domain\UserRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function get(Domain\UserId $userId): ?Domain\User
    {
        return $this->createQueryBuilder()
            ->where('user.id = :id')
            ->setParameters(['id' => $userId->toString()])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    private function createQueryBuilder(): QueryBuilder
    {
        $repo = $this->em->getRepository(Domain\User::class);

        return $repo->createQueryBuilder('user');
    }
}

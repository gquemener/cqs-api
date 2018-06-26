<?php

declare (strict_types = 1);

namespace App\Acme\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;
use App\Acme\Domain\Program as Domain;
use App\Acme\Domain\Program\Program;
use Doctrine\ORM\QueryBuilder;

final class DoctrineProgramRepository implements Domain\ProgramRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function all(): array
    {
        return $this->createQueryBuilder()->getQuery()->execute();
    }

    private function createQueryBuilder(): QueryBuilder
    {
        $repo = $this->em->getRepository(Domain\Program::class);

        return $repo->createQueryBuilder('program');
    }
}

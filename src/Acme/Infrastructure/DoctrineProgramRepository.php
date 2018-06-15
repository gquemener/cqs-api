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

    public function get(Domain\ProgramId $programId): ?Domain\Program
    {
        return $this->createQueryBuilder()
            ->where('program.id = :id')
            ->setParameters(['id' => $programId->toString()])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder()->getQuery()->execute();
    }

    public function add(Domain\Program $program): void
    {
        $this->em->persist($program);
        $this->em->flush();
    }

    public function update(Domain\Program $program): void
    {
        $this->em->flush();
    }

    private function createQueryBuilder(): QueryBuilder
    {
        $repo = $this->em->getRepository(Domain\Program::class);

        return $repo->createQueryBuilder('program');
    }
}

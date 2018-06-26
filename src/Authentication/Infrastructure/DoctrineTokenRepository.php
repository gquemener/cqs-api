<?php

declare (strict_types = 1);

namespace App\Authentication\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;
use App\Authentication\Domain;

final class DoctrineTokenRepository implements Domain\TokenRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Domain\Token $token): void
    {
        $this->em->persist($token);
        $this->em->flush();
    }

    public function get(Domain\TokenValue $tokenValue): ?Domain\Token
    {
        return $this->em->getRepository(Domain\Token::class)->find($tokenValue->toString());
    }
}

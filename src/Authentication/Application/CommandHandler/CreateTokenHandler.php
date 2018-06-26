<?php

declare (strict_types = 1);

namespace App\Authentication\Application\CommandHandler;

use App\Authentication\Domain\TokenRepository;
use App\Authentication\Domain\Token;
use App\Authentication\Application\Command\CreateToken;
use App\Authentication\Domain\TokenValue;

final class CreateTokenHandler
{
    private $repository;

    public function __construct(TokenRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateToken $command): void
    {
        $token = new Token(
            $command->ownerId(),
            new TokenValue(bin2hex(random_bytes(32))),
            3600
        );

        $this->repository->add($token);
    }
}

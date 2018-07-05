<?php

declare(strict_types=1);

namespace App\Authentication\Application\CommandHandler;

use App\Authentication\Application\Command\CreateCredentials;
use App\Authentication\Domain\CredentialsRepository;
use App\Authentication\Domain\Credentials;

final class CreateCredentialsHandler
{
    private $repository;

    public function __construct(CredentialsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateCredentials $command): void
    {
        $credentials = new Credentials(
            $command->ownerId(),
            $command->login(),
            $command->password()
        );

        $this->repository->add($credentials);
    }
}

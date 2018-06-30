<?php

declare (strict_types = 1);

namespace App\Authentication\Application\CommandHandler;

use App\Authentication\Application\Command\CreateCredentials;
use App\Authentication\Domain\CredentialsRepository;
use App\Authentication\Domain\Credentials;
use Prooph\ServiceBus\EventBus;
use App\Authentication\Domain\Events\CredentialsCreationFailed;

final class CreateCredentialsHandler
{
    private $repository;
    private $eventBus;

    public function __construct(
        CredentialsRepository $repository,
        EventBus $eventBus
    ) {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateCredentials $command): void
    {
        $credentials = new Credentials(
            $command->ownerId(),
            $command->login(),
            $command->password()
        );

        try {
            $this->repository->add($credentials);
        } catch (\Exception $e) {
            $this->eventBus->dispatch(CredentialsCreationFailed::withCredentials($credentials));
        }
    }
}

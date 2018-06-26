<?php

declare (strict_types = 1);

namespace App\Acme\Application\CommandHandler;

use App\Acme\Application\Command\RegisterClient;
use App\Acme\Domain\Client as Domain;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class RegisterClientHandler
{
    private $encoderFactory;
    private $repository;

    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        Domain\ClientRepository $repository
    ) {
        $this->encoderFactory = $encoderFactory;
        $this->repository = $repository;
    }

    public function __invoke(RegisterClient $command): void
    {
        $encoder = $this->encoderFactory->getEncoder(Domain\Client::class);

        $client = Domain\Client::register(
            Domain\ClientId::fromString($command->clientId()),
            $command->name(),
            $command->login(),
            $encoder->encodePassword($command->password(), '')
        );

        $this->repository->add($client);
    }
}

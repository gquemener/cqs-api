<?php

declare (strict_types = 1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Prooph\ServiceBus\CommandBus;
use App\Acme\Domain\Program as Domain;
use App\Acme\Application\Command\ProposeProgram;
use App\Acme\Application\Command\JoinProgram;

final class Program
{
    public function index(Domain\ProgramRepository $repository): array
    {
        return $repository->findAll();
    }

    public function show(string $id, Domain\ProgramRepository $repository): ?Domain\Program
    {
        return $repository->get(Domain\ProgramId::fromString($id));
    }

    public function create(Request $request, CommandBus $commandBus): array
    {
        $programId = Domain\ProgramId::generate();

        $command = ProposeProgram::withDescription(
            $request->request->get('description'),
            (int) $request->request->get('maxParticipants'),
            $programId->toString()
        );

        $commandBus->dispatch($command);

        // TODO (2018-06-20 17:43 by Gildas): How to set status code
        return [
            'id' => $programId->toString(),
        ];
    }

    public function join(string $id, Request $request, CommandBus $commandBus): void
    {
        $command = JoinProgram::create(
            $request->request->get('userId', ''),
            $id,
            $request->request->get('date', '')
        );

        $commandBus->dispatch($command);
    }
}

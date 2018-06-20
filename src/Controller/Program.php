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
    public function index(Domain\ProgramRepository $repository): Response
    {
        $programs = $repository->findAll();

        return new JsonResponse($programs);
    }

    public function show(string $id, Domain\ProgramRepository $repository): Response
    {
        $program = $repository->get(Domain\ProgramId::fromString($id));

        return new JsonResponse([
            'id' => (string) $program->programId(),
            'description' => $program->description(),
            'maxParticipants' => $program->maxParticipants(),
        ]);
    }

    public function create(Request $request, CommandBus $commandBus): Response
    {
        $programId = Domain\ProgramId::generate();

        $command = ProposeProgram::withDescription(
            $request->request->get('description'),
            (int) $request->request->get('max_participants'),
            $programId->toString()
        );

        $commandBus->dispatch($command);

        return new Response($programId->toString(), 201);
    }

    public function join(string $id, Request $request, CommandBus $commandBus): Response
    {
        $command = JoinProgram::create(
            $request->request->get('user_id'),
            $id
        );

        $commandBus->dispatch($command);

        return new Response('', 200);
    }
}

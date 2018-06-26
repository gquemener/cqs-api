<?php

declare (strict_types = 1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Prooph\ServiceBus\CommandBus;
use App\Acme\Domain\Client\ClientId;
use App\Acme\Application\Command\RegisterClient;

final class Client
{
    public function create(Request $request, CommandBus $commandBus): View
    {
        $id = ClientId::generate();

        $command = RegisterClient::create(
            $id->toString(),
            $request->request->get('name', ''),
            $request->request->get('login', ''),
            $request->request->get('password', '')
        );
        $commandBus->dispatch($command);

        return View::created([
            'id' => $id->toString(),
        ]);
    }
}

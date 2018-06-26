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
use Symfony\Component\Security\Core\Security;

final class Program
{
    public function index(Security $security, Domain\ProgramRepository $repository): View
    {
        die(var_dump($security->getUser()));
        return View::ok($repository->all());
    }
}

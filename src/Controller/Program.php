<?php

declare(strict_types=1);

namespace App\Controller;

use App\Acme\Domain\Program as Domain;
use Symfony\Component\Security\Core\Security;

final class Program
{
    public function index(Security $security, Domain\ProgramRepository $repository): View
    {
        die(var_dump($security->getUser()));

        return View::ok($repository->all());
    }
}

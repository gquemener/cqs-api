<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Acme\Domain\Program as Domain;

final class Programs extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $program = Domain\Program::define(
                Domain\ProgramId::generate(),
                0 === $i % 2 ? Domain\ProgramType::trainAndCoach() : Domain\ProgramType::trainAndDev(),
                new Domain\ProgramCategory('Catégorie du programme'),
                'Nom du programme',
                'Lorem ipsum dolor sit amet'
            );
            $manager->persist($program);
        }

        $manager->flush();
    }
}

<?php

declare (strict_types = 1);

namespace App\Tests\Functionnal\Program;

use App\Tests\Functionnal\TestCase;
use App\Acme\Domain\Program\ProgramRepository;
use function GuzzleHttp\json_decode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Acme\Domain\Program\Program;
use App\Acme\Domain\Program\ProgramId;

final class ListAllProgramsTest extends TestCase
{
    /**
     * @var EntityManagerInterface
     * @inject
     */
    private $em;

    /**
     * @var ProgramRepository
     * @inject
     */
    private $repository;

    /** @test */
    public function everyone_can_access_all_programs()
    {
        $this->setupDatabase($this->em);

        $response = $this->httpClient->request('GET', '/');
        $data = json_decode((string) $response->getBody(), true);

        $this->assertCount(2, $data);
    }

    /** @test */
    public function everyone_can_propose_a_program()
    {
        $this->setupDatabase($this->em);

        $response = $this->httpClient->request('POST', '/', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'description' => 'Stress Management',
                'maxParticipants' => 2,
            ]
        ]);
        $data = json_decode((string) $response->getBody(), true);

        $this->assertNotNull(
            $this->repository->get(ProgramId::fromString($data['id']))
        );
    }

    public function getFixture(): ?FixtureInterface
    {
        return new class() implements FixtureInterface
        {
            public function load(ObjectManager $manager)
            {
                $manager->persist(Program::propose(ProgramId::generate(), 'An awesome program', 2));
                $manager->persist(Program::propose(ProgramId::generate(), 'An other program', 1));
                $manager->flush();
            }
        };
    }
}

<?php

declare (strict_types = 1);

namespace App\Tests\Functionnal\Program;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Acme\Domain\Program;
use App\Tests\Functionnal\ResetDatabase;
use App\Tests\Functionnal\TestCase;
use function GuzzleHttp\json_decode;

final class ListAllProgramsTest extends TestCase
{
    use ResetDatabase;

    /**
     * @var Program\ProgramRepository
     * @inject
     */
    private $repository;

    /** @test */
    public function everyone_can_access_all_programs()
    {
        $response = $this->httpClient->request('GET', '/');
        $data = json_decode((string) $response->getBody(), true);

        $this->assertCount(2, $data);
    }

    /** @test */
    public function everyone_can_propose_a_program()
    {
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
            $this->repository->get(Program\ProgramId::fromString($data['id']))
        );
    }

    protected function getFixture(): ?FixtureInterface
    {
        return new class() implements FixtureInterface
        {
            public function load(ObjectManager $manager)
            {
                $manager->persist(Program\Program::propose(Program\ProgramId::generate(), 'An awesome program', 2));
                $manager->persist(Program\Program::propose(Program\ProgramId::generate(), 'An other program', 1));
                $manager->flush();
            }
        };
    }
}

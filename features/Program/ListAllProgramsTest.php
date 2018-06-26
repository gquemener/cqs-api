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
    public function as_a_client_list_only_my_programs()
    {
        $response = $this->httpClient->request('GET', '/programs', [
            'Authorization' => 'Bearer client_token',
        ]);

        $this->assertSame(200, $response->getStatusCode());
        $data = json_decode((string) $response->getBody());

        $this->assertCount(2, $data);
        $this->assertValidJson($data, 'programs.json');
    }

    protected function getFixture(): ?FixtureInterface
    {
        return new class() implements FixtureInterface
        {
            public function load(ObjectManager $manager)
            {
                $entities = [];
                $bob = $entities[] = Client::register('bob');
                $alice = $entities[] = Client::register('alice');
                $entities[] = $bob->proposeProgram(
                    Domain\ProgramType::trainAndCoach(),
                    new Domain\ProgramCategory('Happiness'),
                    'Put a smile on these faces',
                    'Lorem ipsum dolor sit amet'
                );
                $entities[] = $bob->proposeProgram(
                    Domain\ProgramType::trainAndDev(),
                    new Domain\ProgramCategory('Stress'),
                    'Remove stress from coffee machine',
                    'Lorem ipsum dolor sit amet'
                );
                $entities[] = $alice->proposeProgram(
                    Domain\ProgramType::trainAndDev(),
                    new Domain\ProgramCategory('Language'),
                    'Working with martians',
                    'Lorem ipsum dolor sit amet'
                );

                foreach ($entities as $entity) {
                    $manager->persist($entity);
                }
                $manager->flush();
            }
        };
    }
}

<?php

declare (strict_types = 1);

namespace App\Tests\Functionnal;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

abstract class TestCase extends BaseTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;

    public function setUp(): void
    {
        $this->setupHttpClient();
        $this->setupDatabase();
    }

    private function setupHttpClient(): void
    {
        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8080',
            'http_errors' => false,
        ]);
    }

    protected function setupDatabase(): void
    {
        if (!$this->em) {
            return;
        }

        $purger = new ORMPurger($this->em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);

        $purger->purge();

        if (null !== $fixture = $this->getFixture()) {
            $loader = new Loader();
            $loader->addFixture($fixture);

            $executor = new ORMExecutor($this->em, $purger);
            $executor->execute($loader->getFixtures());
        }
    }

    protected function assertValidJson($data, string $name): void
    {
        $validator = new \JsonSchema\Validator;
        $validator->validate($data, (object)['$ref' => 'file://' . realpath(__DIR__.'/schemas/' . $name)]);

        $toString = function(array $error): string
        {
            return print_r($error, true);
        };

        $this->assertTrue(
            $validator->isValid(),
            implode("\n", array_map($toString, $validator->getErrors()))
        );
    }
}

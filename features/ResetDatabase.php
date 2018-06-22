<?php

declare (strict_types = 1);

namespace App\Tests\Functionnal;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;

trait ResetDatabase
{
    /**
     * @var EntityManagerInterface
     * @inject
     */
    protected $em;

    protected function getFixture(): ?FixtureInterface
    {
        return null;
    }
}

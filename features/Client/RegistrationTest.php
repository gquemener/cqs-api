<?php

declare (strict_types = 1);

namespace App\Tests\Functionnal\Client;

use App\Tests\Functionnal\ResetDatabase;
use App\Tests\Functionnal\TestCase;
use App\Acme\Domain\Client\ClientId;
use function GuzzleHttp\json_decode;

final class RegistrationTest extends TestCase
{
    use ResetDatabase;

    /**
     * @inject App\Acme\Domain\Client\ClientRepository
     */
    private $repository;

    /** @test */
    public function successfully_register()
    {
        $response = $this->httpClient->request('POST', '/clients', [
            'json' => [
                'name' => 'John Doe'
            ]
        ]);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertNotNull($this->repository->get(
            ClientId::fromString(
                json_decode((string) $response->getBody())->id
            )
        ));
    }
}

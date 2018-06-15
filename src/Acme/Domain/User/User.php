<?php

declare(strict_types=1);

namespace App\Acme\Domain\User;

final class User
{
    private $id;

    public function __construct(UserId $userId)
    {
        $this->id = $userId->toString();
    }

    public function id(): UserId
    {
        return UserId::fromString($this->id);
    }
}

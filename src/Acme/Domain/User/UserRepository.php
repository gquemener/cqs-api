<?php

declare (strict_types = 1);

namespace App\Acme\Domain\User;

interface UserRepository
{
    public function get(UserId $userId): ?User;
}

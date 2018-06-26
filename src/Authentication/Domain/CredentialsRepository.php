<?php

declare (strict_types = 1);

namespace App\Authentication\Domain;

interface CredentialsRepository
{
    public function add(Credentials $token): void;

    public function get(CredentialsId $id): ?Credentials;
}

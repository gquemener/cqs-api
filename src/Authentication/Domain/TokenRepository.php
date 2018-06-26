<?php

declare (strict_types = 1);

namespace App\Authentication\Domain;

interface TokenRepository
{
    public function add(Token $token): void;

    public function get(TokenValue $tokenValue): ?Token;
}

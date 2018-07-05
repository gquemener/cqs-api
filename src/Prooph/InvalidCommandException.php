<?php

declare(strict_types=1);

namespace App\Prooph;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final class InvalidCommandException extends \RuntimeException
{
    private $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
    }

    public function violations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}

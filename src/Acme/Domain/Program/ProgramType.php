<?php

declare(strict_types=1);

namespace App\Acme\Domain\Program;

final class ProgramType
{
    public const OPTIONS = [
        'TrainAndCoach' => 0,
        'TrainAndDev' => 1,
    ];

    public const TrainAndCoach = 0;
    public const TrainAndDev = 1;

    private $name;
    private $value;

    private function __construct(string $name)
    {
        $this->name = $name;
        $this->value = self::OPTIONS[$name];
    }

    public static function trainAndCoach(): self
    {
        return new self('TrainAndCoach');
    }

    public static function trainAndDev(): self
    {
        return new self('TrainAndDev');
    }

    public static function fromName(string $value): self
    {
        if (!isset(self::OPTIONS[$value])) {
            throw new \InvalidArgumentException('Unknown enum name given');
        }

        return self::{$value}();
    }

    public static function fromValue($value): self
    {
        foreach (self::OPTIONS as $name => $v) {
            if ($v === $value) {
                return self::{$name}();
            }
        }

        throw new \InvalidArgumentException('Unknown enum value given');
    }

    public function equals(ProgramType $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->name === $other->name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

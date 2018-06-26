<?php

declare(strict_types=1);

namespace App\Acme\Domain\Program;

use App\DomainEvent;

final class Program implements DomainEvent\Provider, \JsonSerializable
{
    use DomainEvent\RecordEvents;

    private $id;
    private $type;
    private $category;
    private $name;
    private $description;

    private function __construct(
        ProgramId $id,
        ProgramType $type,
        ProgramCategory $category,
        string $name,
        string $description
    ) {
        $this->id = $id->toString();
        $this->type = $type->value();
        $this->category = $category->value();
        $this->name = $name;
        $this->description = $description;
    }

    public static function define(
        ProgramId $id,
        ProgramType $type,
        ProgramCategory $category,
        string $name,
        string $description
    ): self {
        return new self($id, $type, $category, $name, $description);
    }

    public function id(): ProgramId
    {
        return ProgramId::fromString($this->id);
    }

    public function type(): ProgramType
    {
        return ProgramType::fromValue($this->type);
    }

    public function category(): ProgramCategory
    {
        return new ProgramCategory($this->category);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function createTrack(): Track
    {
        return new Track($this->id());
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'type' => $this->type()->value(),
            'category' => $this->category()->value(),
            'name' => $this->name(),
            'description' => $this->description(),
        ];
    }
}

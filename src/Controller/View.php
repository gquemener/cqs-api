<?php

declare(strict_types=1);

namespace App\Controller;

final class View
{
    private $statusCode;
    private $content;

    private function __construct(int $statusCode, ?array $content)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
    }

    public static function created(array $content = null): self
    {
        return new self(201, $content);
    }

    public static function ok(array $content = null): self
    {
        return new self(201, $content);
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function content(): ?array
    {
        return $this->content;
    }
}

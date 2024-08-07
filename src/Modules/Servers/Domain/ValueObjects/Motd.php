<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\ValueObjects;

final readonly class Motd
{
    public ?string $firstLine;
    public ?string $secondLine;

    public function __construct(?string $firstLine, ?string $secondLine)
    {
        $this->firstLine = $firstLine ? substr(trim($firstLine), 0, 255) : null;
        $this->secondLine = $secondLine ? substr(trim($secondLine), 0, 255) : null;
    }
}
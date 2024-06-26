<?php

namespace App\Modules\Servers\Domain\ValueObjects;

final readonly class Motd
{
    public string $firstLine;
    public string $secondLine;

    public function __construct(string $firstLine, string $secondLine)
    {
        $this->firstLine = trim($firstLine);
        $this->secondLine = trim($secondLine);
    }
}
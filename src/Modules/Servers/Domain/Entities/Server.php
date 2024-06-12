<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Entities;

use App\Modules\Servers\Domain\ValueObjects\Motd;
use App\Modules\Servers\Domain\ValueObjects\Players;

final readonly class Server
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $ip,
        public ?string $version,
        public Players $players,
        public bool $online,
        public Motd $motd,
        public ?string $icon = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    )
    {
    }
}
<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Clients;

final readonly class OnlineServerData implements ServerData
{
    public function __construct(
        public string $name,
        public bool $online,
        public string $ip,
        public ?string $version,
        public int $currentPlayers,
        public int $maxPlayers,
        public ?string $motdFirstLine,
        public ?string $motdSecondLine,
        public ?string $icon,
    )
    {
    }
}
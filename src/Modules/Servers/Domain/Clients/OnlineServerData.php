<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Clients;

final readonly class OnlineServerData implements ServerData
{
    public ?string $motdFirstLine;
    public ?string $motdSecondLine;

    public function __construct(
        public string $name,
        public bool $online,
        public string $ip,
        public ?string $version,
        public int $currentPlayers,
        public int $maxPlayers,
        ?string $motdFirstLine,
        ?string $motdSecondLine,
        public ?string $icon,
    )
    {

        if ($motdFirstLine) {
            $this->motdFirstLine = substr($motdFirstLine, 0, 255);
        }

        if ($motdSecondLine) {
            $this->motdSecondLine = substr($motdSecondLine, 0, 255);
        }
    }
}
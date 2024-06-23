<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Clients;

final readonly class OfflineServerData implements ServerData
{
    public function __construct(
        public string $name,
        public bool $online
    )
    {

    }
}
<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Clients;

use App\Modules\Servers\Domain\Entities\Server;

final readonly class OfflineServerData implements ServerData
{
    public function __construct(
        public string $name,
        public bool $online
    )
    {

    }

    public function toEntity(): Server
    {
        // TODO: Implement toEntity() method.
    }
}
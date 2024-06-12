<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Clients;

interface ServerDataClient
{
    public function getServerData(string $serverName): ServerData;
}
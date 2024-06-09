<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain;

interface ServerRepository
{
    public function getPaginatedServers(int $page, int $limit);
}
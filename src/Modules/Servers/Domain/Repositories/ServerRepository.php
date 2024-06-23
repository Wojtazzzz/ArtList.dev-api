<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Repositories;

use App\Modules\Servers\Domain\Entities\Server;

interface ServerRepository
{
    public function getPaginatedServers(int $page, int $limit);

    public function create(Server $server): void;

    public function existsByName(string $name): bool;

    public function getAllToUpdate();

    public function update(int $id, Server $server): void;
}
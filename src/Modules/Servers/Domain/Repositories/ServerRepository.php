<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Repositories;

use App\Modules\Servers\Domain\Entities\Server;

interface ServerRepository
{
	public function getPaginatedServers(int $page, int $limit, ?string $order, ?string $name): array;

	public function getCount(): int;

	public function create(Server $server): void;

	public function existsByName(string $name): bool;

	public function getToUpdate();

	public function update(int $id, Server $server): void;

	public function markAsOffline(int $id): void;

	public function getByName(string $name): \App\Modules\Servers\Infrastructure\Entities\Server|null;
}
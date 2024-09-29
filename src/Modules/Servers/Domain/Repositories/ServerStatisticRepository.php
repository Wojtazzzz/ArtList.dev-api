<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Repositories;

use App\Modules\Servers\Domain\Entities\Server as DomainServerEntity;

interface ServerStatisticRepository
{
	public function create(DomainServerEntity $data): void;

	public function getLastForServer(int $serverId): mixed;

	public function deleteOlderThanMonth(): void;
}
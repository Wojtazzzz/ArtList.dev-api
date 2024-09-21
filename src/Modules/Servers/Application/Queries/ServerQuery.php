<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Queries;

use App\Shared\Query;

final class ServerQuery implements Query
{
	public function __construct(
		public string $serverName
	)
	{
	}
}
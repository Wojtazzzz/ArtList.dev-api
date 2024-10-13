<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Entities;

use App\Modules\Servers\Domain\ValueObjects\Motd;
use App\Modules\Servers\Domain\ValueObjects\Players;
use App\Modules\Servers\Domain\ValueObjects\Version;

final readonly class Server
{
	public function __construct(
		public ?int $id,
		public string $name,
		public bool $online,
		public ?string $ip = null,
		public ?Version $version = null,
		public ?Players $players = null,
		public ?Motd $motd = null,
		public ?string $icon = null,
		public ?string $createdAt = null,
		public ?string $updatedAt = null,
	)
	{
	}
}
<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Dto;

use App\Modules\Servers\Infrastructure\Entities\Server;
use App\Modules\Servers\Infrastructure\Entities\ServerStatistic;

final readonly class ServerResponse
{
	public int $id;

	public string $name;

	public ?string $motdFirstLine;

	public ?string $motdSecondLine;

	public ?bool $online;

	public string $version;

	public array $statistics;

	public function __construct(Server $server)
	{
		$this->id = $server->getId();
		$this->name = $server->name;
		$this->motdFirstLine = $server->motdFirstLine;
		$this->motdSecondLine = $server->motdSecondLine;
		$this->online = $server->online;
		$this->version = $server->version;
		$this->statistics = array_map(function (ServerStatistic $stat): array {
			return [
				'date' => $stat->createdAt,
				'value' => $stat->players,
			];
		}, $server->getServerStatistics()
			->slice(0, 12));
	}
}
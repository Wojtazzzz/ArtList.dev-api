<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Dto;

final readonly class ServersPaginatedResponse
{
	public int $lastPage;

	public int|null $prevPage;

	public int|null $nextPage;

	public array $data;

	public function __construct(
		public int $page,
		public int $total,
		public int $limit,
		array $data
	)
	{
		$this->lastPage = max(1, (int)ceil($this->total / $limit));
		$this->prevPage = ($this->page > 1) ? $this->page - 1 : null;
		$this->nextPage = ($this->page >= $this->lastPage) ? null : $this->page + 1;
		$this->data = array_map(function (array $server): array {
			return [
				'id' => $server['id'],
				'name' => $server['name'],
				'online' => $server['online'],
				'icon' => $server['icon'],
				'version' => $server['version'],
				'currentPlayers' => $server['currentPlayers'],
				'maxPlayers' => $server['maxPlayers'],
				'motdFirstLine' => $server['motdFirstLine'],
				'motdSecondLine' => $server['motdSecondLine'],
			];
		}, $data);
	}
}
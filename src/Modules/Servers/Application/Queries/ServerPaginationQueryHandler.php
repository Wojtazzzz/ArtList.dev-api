<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Queries;

use App\Modules\Servers\Application\Dto\ServersPaginatedResponse;
use App\Modules\Servers\Domain\Repositories\ServerRepository;
use App\Shared\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ServerPaginationQueryHandler implements QueryHandler
{
	public function __construct(
		private ServerRepository $repository
	)
	{
	}

	public function __invoke(ServerPaginationQuery $query): ServersPaginatedResponse
	{
		return new ServersPaginatedResponse(
			page: $query->page,
			total: $this->repository->getCount(),
			limit: $query->limit,
			data: $this->repository->getPaginatedServers($query->page, $query->limit, $query->order, $query->name)
		);
	}
}
<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Queries;

use App\Modules\Servers\Domain\Repositories\ServerRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ServerPaginationQueryHandler
{
    public function __construct(
        private ServerRepository $repository
    )
    {
    }

    public function __invoke(ServerPaginationQuery $query): array
    {
        return $this->repository->getPaginatedServers($query->page, $query->limit);
    }
}
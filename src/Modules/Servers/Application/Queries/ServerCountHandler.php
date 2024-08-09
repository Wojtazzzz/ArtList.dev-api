<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Queries;

use App\Modules\Servers\Domain\Repositories\ServerRepository;
use App\Shared\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ServerCountHandler implements QueryHandler
{
    public function __construct(
        private ServerRepository $repository
    )
    {
    }

    public function __invoke(ServerCountQuery $query): int
    {
        return $this->repository->getCount();
    }
}
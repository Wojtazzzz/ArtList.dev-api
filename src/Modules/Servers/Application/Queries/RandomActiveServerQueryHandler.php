<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Queries;

use App\Modules\Servers\Application\Dto\ServerResponse;
use App\Modules\Servers\Application\Exceptions\ServerNotFoundException;
use App\Modules\Servers\Domain\Repositories\ServerRepository;
use App\Shared\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class RandomActiveServerQueryHandler implements QueryHandler
{
	public function __construct(
		private ServerRepository $repository
	)
	{
	}

	/**
	 * @throws ServerNotFoundException
	 */
	public function __invoke(RandomActiveServerQuery $query): ServerResponse
	{
		$server = $this->repository->getRandomActiveServer();

		if (!$server) {
			throw new ServerNotFoundException();
		}

		return new ServerResponse($server);
	}
}

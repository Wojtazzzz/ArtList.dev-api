<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Commands\DestroyStatistics;

use App\Modules\Servers\Domain\Repositories\ServerStatisticRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DestroyStatisticsCommandHandler
{
	public function __construct(
		private ServerStatisticRepository $statisticRepository,
	)
	{
	}

	public function __invoke(DestroyStatisticsCommand $command): void
	{
		$this->statisticRepository->deleteOlderThanMonth();
	}
}
<?php

declare(strict_types=1);

namespace App\Modules\Servers\Api;

use App\Modules\Servers\Application\Commands\DestroyStatistics\DestroyStatisticsCommand;
use App\Shared\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ServerStatisticController extends AbstractController
{
	public function __construct(
		private readonly CommandBus $commandBus,
	)
	{
	}

	#[Route(path: '/server_statistics', name: 'servers.destroy', methods: ['DELETE'])]
	public function destroy(DestroyStatisticsCommand $query, Request $request): JsonResponse
	{
		if ($request->headers->get('Authorization') !== 'Bearer ' . $this->getParameter('cron_secret')) {
			return $this->json([], 401);
		}

		$this->commandBus->handle($query);

		return $this->json([]);
	}
}
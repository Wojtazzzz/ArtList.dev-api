<?php

declare(strict_types=1);

namespace App\Modules\Servers\Api;

use App\Modules\Servers\Application\Commands\AddServer\AddServerCommand;
use App\Modules\Servers\Application\Commands\UpdateServers\UpdateServersCommand;
use App\Modules\Servers\Application\Queries\ServerCountQuery;
use App\Modules\Servers\Application\Queries\ServerPaginationQuery;
use App\Modules\Servers\Application\Queries\ServerQuery;
use App\Shared\CommandBus;
use App\Shared\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ServerController extends AbstractController
{
	public function __construct(
		private readonly QueryBus $queryBus,
		private readonly CommandBus $commandBus,
	)
	{
	}

	#[Route(path: '/servers', name: 'servers.index', methods: ['GET'])]
	public function index(
		#[MapQueryString(
			validationGroups: ['strict', 'edit'],
			validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
		)] ServerPaginationQuery $query,
	): JsonResponse
	{
		return $this->json($this->queryBus->handle($query));
	}

	#[Route(path: '/servers/count', name: 'servers.count', methods: ['GET'])]
	public function count(ServerCountQuery $query): JsonResponse
	{
		return $this->json([
			'servers' => $this->queryBus->handle($query)
		]);
	}

	#[Route(path: '/servers/{serverName}', name: 'servers.show', methods: ['GET'])]
	public function show(string $serverName): JsonResponse
	{
		$query = new ServerQuery(
			serverName: $serverName
		);

		return $this->json($this->queryBus->handle($query));
	}

	#[Route('/servers', name: 'servers.store', methods: ['POST'])]
	public function store(
		#[MapRequestPayload(
			validationGroups: ['strict', 'edit'],
			validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
		)] AddServerCommand $command,
	): JsonResponse
	{
		$this->commandBus->handle($command);

		return $this->json([]);
	}

	#[Route(path: '/servers', name: 'servers.update', methods: ['PUT'])]
	public function update(
		#[MapRequestPayload(
			validationGroups: ['strict', 'edit'],
			validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
		)] UpdateServersCommand $command,
		Request $request
	): JsonResponse
	{
		if ($request->headers->get('Authorization') !== 'Bearer ' . $this->getParameter('cron_secret')) {
			return $this->json([], 401);
		}

		$this->commandBus->handle($command);

		return $this->json([]);
	}
}
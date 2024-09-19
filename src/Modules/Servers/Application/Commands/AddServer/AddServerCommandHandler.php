<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Commands\AddServer;

use App\Modules\Servers\Domain\Exceptions\CannotCreateOfflineServerException;
use App\Modules\Servers\Domain\Exceptions\InvalidPlayersException;
use App\Modules\Servers\Domain\Exceptions\ServerAlreadyExistsException;
use App\Modules\Servers\Domain\Repositories\ServerRepository;
use App\Modules\Servers\Domain\Services\ServerService;
use App\Modules\Servers\Infrastructure\Clients\ClientException;
use App\Modules\Servers\Infrastructure\Clients\Mcsrvstat3Client;
use App\Modules\Servers\Infrastructure\Repositories\ServerStatisticRepository;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsMessageHandler]
final readonly class AddServerCommandHandler
{
	public function __construct(
		private ServerRepository $serverRepository,
		private ServerStatisticRepository $statisticRepository,
		private ServerService $service,
		private Mcsrvstat3Client $client,
	)
	{
	}

	/**
	 * @throws CannotCreateOfflineServerException
	 * @throws RedirectionExceptionInterface
	 * @throws DecodingExceptionInterface
	 * @throws ClientExceptionInterface
	 * @throws TransportExceptionInterface
	 * @throws ClientException
	 * @throws ServerExceptionInterface
	 * @throws InvalidPlayersException
	 * @throws ServerAlreadyExistsException
	 * @throws ORMException
	 */
	public function __invoke(AddServerCommand $command): void
	{
		$serverData = $this->client->getServerData($command->name);

		$server = $this->service->create($serverData);

		$this->serverRepository->create($server);
		$this->statisticRepository->create($server);
	}
}
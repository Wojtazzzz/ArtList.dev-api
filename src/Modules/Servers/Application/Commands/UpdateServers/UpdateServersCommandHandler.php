<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Commands\UpdateServers;

use App\Modules\Servers\Domain\Entities\ServerStatistics;
use App\Modules\Servers\Domain\Exceptions\InvalidPlayersException;
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
final readonly class UpdateServersCommandHandler
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
	 * @param UpdateServersCommand $command
	 * @throws ClientExceptionInterface
	 * @throws DecodingExceptionInterface
	 * @throws RedirectionExceptionInterface
	 * @throws TransportExceptionInterface
	 * @throws InvalidPlayersException
	 * @throws ServerExceptionInterface
	 * @throws ORMException
	 */
	public function __invoke(UpdateServersCommand $command): void
	{
		$servers = $this->serverRepository->getToUpdate();

		foreach ($servers as $server) {
			try {
				$data = $this->client->getServerData($server['name']);

				$entity = $this->service->update($server['id'], $data);

				if ($entity->online) {
					$this->serverRepository->update($server['id'], $entity);
				} else {
					$this->serverRepository->markAsOffline($server['id']);
				}

				$serverStatistics = new ServerStatistics(
					lastServerStatistic: $this->statisticRepository->getLastForServer($server['id']),
				);

				if (!$serverStatistics->hasStatFromCurrentHour()) {
					$this->statisticRepository->create($entity);
				}
			} catch (ClientException $e) {
				continue;
			}
		}
	}
}
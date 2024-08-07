<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Commands\UpdateServers;

use App\Modules\Servers\Domain\Exceptions\InvalidPlayersException;
use App\Modules\Servers\Domain\Repositories\ServerRepository;
use App\Modules\Servers\Domain\Services\ServerService;
use App\Modules\Servers\Infrastructure\Clients\ClientException;
use App\Modules\Servers\Infrastructure\Clients\Mcsrvstat3Client;
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
        private ServerRepository $repository,
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
     */
    public function __invoke(UpdateServersCommand $command): void
    {
        $servers = $this->repository->getAllToUpdate();

        foreach ($servers as $server) {
            try {
                $data = $this->client->getServerData($server['name']);

                $entity = $this->service->update($server['id'], $data);

                if (!$entity->online) {
                    continue;
                }

                $this->repository->update($server['id'], $entity);
            } catch (ClientException $e) {
                continue;
            }
        }
    }
}
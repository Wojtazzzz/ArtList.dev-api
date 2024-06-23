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
        private ServerRepository $repository,
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
     */
    public function __invoke(AddServerCommand $command): void
    {
        $serverData = $this->client->getServerData($command->name);

        $server = $this->service->create($serverData);

        $this->repository->create($server);
    }
}
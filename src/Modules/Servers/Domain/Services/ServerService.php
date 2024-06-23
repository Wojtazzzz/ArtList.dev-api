<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Services;

use App\Modules\Servers\Domain\Clients\OnlineServerData;
use App\Modules\Servers\Domain\Clients\ServerData;
use App\Modules\Servers\Domain\Entities\Server;
use App\Modules\Servers\Domain\Exceptions\CannotCreateOfflineServerException;
use App\Modules\Servers\Domain\Exceptions\InvalidPlayersException;
use App\Modules\Servers\Domain\Exceptions\ServerAlreadyExistsException;
use App\Modules\Servers\Domain\Repositories\ServerRepository;
use App\Modules\Servers\Domain\ValueObjects\Motd;
use App\Modules\Servers\Domain\ValueObjects\Players;

final readonly class ServerService
{

    public function __construct(private ServerRepository $repository)
    {
    }

    /**
     * @throws CannotCreateOfflineServerException
     * @throws InvalidPlayersException
     * @throws ServerAlreadyExistsException
     */
    public function create(ServerData $data): Server
    {
        if (!($data instanceof OnlineServerData)) {
            throw new CannotCreateOfflineServerException();
        }

        if ($this->repository->existsByName($data->name)) {
            throw new ServerAlreadyExistsException();
        }

        return new Server(
            id: null,
            name: $data->name,
            online: true,
            ip: $data->ip,
            version: $data->version,
            players: new Players($data->currentPlayers, $data->maxPlayers),
            motd: new Motd($data->motdFirstLine, $data->motdSecondLine),
            icon: $data->icon,
        );
    }

    /**
     * @throws InvalidPlayersException
     */
    public function update(int $id, ServerData $data): Server
    {
        if (!($data instanceof OnlineServerData)) {
            return new Server(
                id: $id,
                name: $data->name,
                online: false
            );
        }

        return new Server(
            id: $id,
            name: $data->name,
            online: true,
            ip: $data->ip,
            version: $data->version,
            players: new Players($data->currentPlayers, $data->maxPlayers),
            motd: new Motd($data->motdFirstLine, $data->motdSecondLine),
            icon: $data->icon,
        );
    }
}
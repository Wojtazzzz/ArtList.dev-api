<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Services;

use App\Modules\Servers\Domain\Clients\OnlineServerData;
use App\Modules\Servers\Domain\Clients\ServerData;
use App\Modules\Servers\Domain\Entities\Server;
use App\Modules\Servers\Domain\Exceptions\CannotCreateOfflineServerException;
use App\Modules\Servers\Domain\Exceptions\InvalidPlayersException;
use App\Modules\Servers\Domain\ValueObjects\Motd;
use App\Modules\Servers\Domain\ValueObjects\Players;

final readonly class ServerService
{
    /**
     * @throws CannotCreateOfflineServerException
     * @throws InvalidPlayersException
     */
    public function create(ServerData $data): Server
    {
        if (!($data instanceof OnlineServerData)) {
            throw new CannotCreateOfflineServerException();
        }

        return new Server(
            null,
            $data->name,
            $data->ip,
            $data->version,
            new Players($data->currentPlayers, $data->maxPlayers),
            true,
            new Motd($data->motdFirstLine, $data->motdSecondLine),
            $data->icon
        );
    }
}
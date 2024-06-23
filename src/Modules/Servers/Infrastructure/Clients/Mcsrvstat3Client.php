<?php

declare(strict_types=1);

namespace App\Modules\Servers\Infrastructure\Clients;

use App\Modules\Servers\Domain\Clients\OfflineServerData;
use App\Modules\Servers\Domain\Clients\OnlineServerData;
use App\Modules\Servers\Domain\Clients\ServerData;
use App\Modules\Servers\Domain\Clients\ServerDataClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Mcsrvstat3Client implements ServerDataClient
{
    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws ClientException
     */
    public function getServerData(string $serverName): ServerData
    {
        $response = $this->client->request(
            'GET',
            "https://api.mcsrvstat.us/3/{$serverName}"
        );

        if ($response->getStatusCode() !== 200) {
            throw new ClientException();
        }

        $data = $response->toArray();

        if (!isset($data['online'])) {
            throw new ClientException();
        }

        if ($data['online'] !== true) {
            return new OfflineServerData($serverName, false);
        }

        return new OnlineServerData(
            $serverName,
            true,
            $data['ip'],
            $data['version'],
            $data['players']['online'],
            $data['players']['max'],
            !empty($data['motd']['clean'][0]) ? $data['motd']['clean'][0] : null,
            !empty($data['motd']['clean'][1]) ? $data['motd']['clean'][1] : null,
            !empty($data['icon']) ? $data['icon'] : null
        );
    }
}
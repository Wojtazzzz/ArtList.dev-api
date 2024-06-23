<?php

declare(strict_types=1);

namespace App\Modules\Servers\Infrastructure\Clients;

final class ClientException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Wczytywanie danych serwera nie powiodło się. Proszę spróbować ponownie później.");
    }
}
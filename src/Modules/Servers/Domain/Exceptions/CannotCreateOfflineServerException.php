<?php

namespace App\Modules\Servers\Domain\Exceptions;

use App\Shared\Exceptions\DomainException;

final readonly class CannotCreateOfflineServerException extends DomainException
{
    public function __construct()
    {
        parent::__construct("Serwer nie istnieje lub jest offline.");
    }
}
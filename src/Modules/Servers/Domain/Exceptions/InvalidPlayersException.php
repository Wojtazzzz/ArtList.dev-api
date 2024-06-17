<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Exceptions;

use App\Shared\Exceptions\DomainException;

final class InvalidPlayersException extends DomainException implements ServerException
{
    public function __construct()
    {
        parent::__construct('Przesłano nieprawidłową liczbę graczy.');
    }
}
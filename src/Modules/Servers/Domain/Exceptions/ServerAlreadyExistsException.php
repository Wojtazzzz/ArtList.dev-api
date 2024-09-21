<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Exceptions;

use App\Modules\Servers\Api\ServerException;
use App\Shared\Exceptions\DomainException;

final class ServerAlreadyExistsException extends DomainException implements ServerException
{
	public function __construct()
	{
		parent::__construct('Podany serwer już istnieje.');
	}
}
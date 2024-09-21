<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Exceptions;

use App\Modules\Servers\Api\ServerException;
use App\Shared\Exceptions\ApplicationException;

final class ServerNotFoundException extends ApplicationException implements ServerException
{
	public function __construct()
	{
		parent::__construct('Serwer nie został znaleziony.');
	}
}
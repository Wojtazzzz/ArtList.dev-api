<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

abstract class ApplicationException extends \Exception
{
	public function __construct(string $message)
	{
		parent::__construct($message);
	}
}
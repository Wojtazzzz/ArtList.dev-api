<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use App\Modules\Servers\Api\ServerException;
use App\Modules\Servers\Api\ServerExceptionHandler;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final readonly class ExceptionListener
{
	#[AsEventListener]
	public function __invoke(ExceptionEvent $event): void
	{
		$exception = $event->getThrowable();

		if ($exception instanceof HandlerFailedException) {
			$exception = $exception->getPrevious();
		}

		$context = match (true) {
			$exception instanceof ServerException => new ServerExceptionHandler($exception),
			default => new UnknownExceptionHandler(),
		};

		$context->handleException($event);
	}
}
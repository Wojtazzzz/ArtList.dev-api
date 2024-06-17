<?php

namespace App\Shared\Exceptions;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final readonly class UnknownExceptionHandler implements ExceptionStrategy
{
    public function handleException(ExceptionEvent $event): void
    {
        $event->setResponse(new JsonResponse([
            'message' => 'Unknown server error.',
            'debug' => $event->getThrowable()->getMessage(), // dev purposes
        ], 500));
    }
}
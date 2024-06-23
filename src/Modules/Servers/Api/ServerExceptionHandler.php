<?php

declare(strict_types=1);

namespace App\Modules\Servers\Api;

use App\Modules\Servers\Domain\Exceptions\CannotCreateOfflineServerException;
use App\Modules\Servers\Domain\Exceptions\InvalidPlayersException;
use App\Modules\Servers\Domain\Exceptions\ServerAlreadyExistsException;
use App\Modules\Servers\Domain\Exceptions\ServerException;
use App\Modules\Servers\Infrastructure\Clients\ClientException;
use App\Shared\Exceptions\ExceptionStrategy;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final readonly class ServerExceptionHandler implements ExceptionStrategy
{
    private int $httpCode;

    public function __construct(private ServerException $exception)
    {
        $this->httpCode = match (true) {
            $this->exception instanceof CannotCreateOfflineServerException => 400,
            $this->exception instanceof InvalidPlayersException, $this->exception instanceof ClientException => 502,
            $this->exception instanceof ServerAlreadyExistsException => 422,
        };
    }

    public function handleException(ExceptionEvent $event): void
    {
        $event->setResponse(new JsonResponse([
            'message' => $this->exception->getMessage(),
        ], $this->httpCode));
    }
}
<?php

declare(strict_types=1);

namespace App\Modules\Servers\Api;

use App\Modules\Servers\Application\Queries\ServerPaginationQuery;
use App\Shared\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

final class ServerController extends AbstractController
{
    public function __construct(
        private QueryBus $queryBus
    )
    {
    }

    #[Route('/servers', name: 'servers.index', methods: ['GET'])]
    public function index(
        #[MapQueryString(
            validationGroups: ['strict', 'edit'],
            validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
        )] ServerPaginationQuery $query,
    ): JsonResponse
    {
        return $this->json([
            'hello' => $this->queryBus->handle($query)
        ]);
    }
}
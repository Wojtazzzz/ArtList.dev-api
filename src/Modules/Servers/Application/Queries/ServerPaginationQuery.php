<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Queries;

use App\Shared\Query;
use Symfony\Component\Validator\Constraints as Assert;

final class ServerPaginationQuery implements Query
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public int $page,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public int $limit,
    )
    {
    }
}
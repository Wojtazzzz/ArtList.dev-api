<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Queries;

use App\Shared\Query;
use Symfony\Component\Validator\Constraints as Assert;

final class ServerPaginationQuery implements Query
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\PositiveOrZero]
        public int $page,

        #[Assert\NotBlank]
        #[Assert\PositiveOrZero]
        public int $limit,

        public ?string $name,

        #[Assert\Choice(['name', '-name', 'players', '-players'])]
        public ?string $order,
    )
    {
    }
}
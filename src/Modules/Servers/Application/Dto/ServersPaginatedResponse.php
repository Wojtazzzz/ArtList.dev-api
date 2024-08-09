<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Dto;

final readonly class ServersPaginatedResponse
{
    public int $lastPage;

    public int|null $prevPage;

    public int|null $nextPage;

    public function __construct(public int $page, public int $total, public int $limit, public array $data)
    {
        $this->lastPage = max(1, (int)($this->total / $limit));
        $this->prevPage = ($this->page > 1) ? $this->page - 1 : null;
        $this->nextPage = ($this->page > $this->lastPage) ? $this->page + 1 : null;
    }
}
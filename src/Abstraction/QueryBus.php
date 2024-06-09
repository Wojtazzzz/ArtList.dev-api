<?php

declare(strict_types=1);

namespace App\Abstraction;

interface QueryBus
{
    public function handle(Query $query): mixed;
}
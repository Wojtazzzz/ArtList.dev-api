<?php

declare(strict_types=1);

namespace App\Shared;

interface CommandBus
{
    public function handle(Command $command): void;
}
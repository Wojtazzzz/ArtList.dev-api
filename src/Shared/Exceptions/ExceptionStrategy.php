<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

interface ExceptionStrategy
{
    public function handleException(ExceptionEvent $event): void;
}
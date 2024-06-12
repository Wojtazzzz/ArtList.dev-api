<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Commands;

use App\Shared\Command;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class AddServerCommand implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 128)]
        public string $name,
    )
    {
    }
}
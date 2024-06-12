<?php

namespace App\Modules\Servers\Domain\ValueObjects;

use App\Modules\Servers\Domain\InvalidPlayersException;

final readonly class Players
{
    /**
     * @throws InvalidPlayersException
     */
    public function __construct(
        private int $currentPlayers,
        private int $maxPlayers
    )
    {
        if ($this->currentPlayers < 0 || $this->maxPlayers < 0) {
            throw new InvalidPlayersException();
        }

        if ($this->currentPlayers > $this->maxPlayers) {
            throw new InvalidPlayersException();
        }
    }
}
<?php

namespace App\Modules\Servers\Domain\ValueObjects;

use App\Modules\Servers\Domain\Exceptions\InvalidPlayersException;

final readonly class Players
{
	/**
	 * @throws InvalidPlayersException
	 */
	public function __construct(
		public int $currentPlayers,
		public int $maxPlayers
	)
	{
		if ($this->currentPlayers < 0 || $this->maxPlayers < 0) {
			throw new InvalidPlayersException();
		}

//        Reason: Too common error :/
//        if ($this->currentPlayers > $this->maxPlayers) {
//            throw new InvalidPlayersException();
//        }
	}
}
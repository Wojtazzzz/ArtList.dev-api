<?php

declare(strict_types=1);

namespace App\Modules\Servers\Domain\Entities;

final readonly class ServerStatistics
{
	public function __construct(
		private ?array $lastServerStatistic
	)
	{
	}

	public function hasStatFromCurrentHour(): bool
	{
		if (!$this->lastServerStatistic) {
			return false;
		}

		$lastServerStatisticDate = $this->lastServerStatistic['createdAt']->format('Y-m-d H');

		return $lastServerStatisticDate === date('Y-m-d H');
	}
}
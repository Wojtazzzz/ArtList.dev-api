<?php

namespace App\Modules\Servers\Domain\ValueObjects;

final readonly class Version
{
	public string $version;

	public function __construct(?string $version)
	{
		if (!$version) {
			$this->version = '';
		} else {
			$this->version = trim((string)preg_replace('/[^0-9x\s.,\-\/]/', '', $version));
		}
	}

	public function __toString(): string
	{
		return $this->version;
	}
}
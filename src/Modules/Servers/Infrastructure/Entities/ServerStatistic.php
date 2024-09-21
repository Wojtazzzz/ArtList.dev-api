<?php

declare(strict_types=1);

namespace App\Modules\Servers\Infrastructure\Entities;

use App\Modules\Servers\Infrastructure\Repositories\ServerStatisticRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'server_statistic')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ServerStatisticRepository::class)]
final class ServerStatistic
{
	#[ORM\Id]
	#[ORM\GeneratedValue(strategy: 'SEQUENCE')]
	#[ORM\SequenceGenerator(sequenceName: 'id')]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
	public int $players = 0;

	#[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
	public ?bool $online = null;

	#[ORM\ManyToOne(targetEntity: Server::class, fetch: 'EXTRA_LAZY')]
	private Server $server;

	#[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
	public \DateTimeImmutable $createdAt;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getServer(): ?Server
	{
		return $this->server;
	}

	public function setServer(?Server $server): self
	{
		$this->server = $server;

		return $this;
	}

	#[ORM\PrePersist]
	public function setCreatedAtValue(): void
	{
		$this->createdAt = new \DateTimeImmutable();
	}
}

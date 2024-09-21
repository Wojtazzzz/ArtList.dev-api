<?php

declare(strict_types=1);

namespace App\Modules\Servers\Infrastructure\Entities;

use App\Modules\Servers\Infrastructure\Repositories\ServerRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

#[ORM\Entity(repositoryClass: ServerRepository::class)]
#[ORM\Table(name: 'server')]
#[ORM\HasLifecycleCallbacks]
final class Server
{
	#[ORM\Id]
	#[ORM\GeneratedValue(strategy: 'SEQUENCE')]
	#[ORM\SequenceGenerator(sequenceName: 'id')]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 64)]
	public ?string $name = null;

	#[ORM\Column(length: 32, nullable: true)]
	public ?string $ip = null;

	#[ORM\Column(length: 255, nullable: true)]
	public ?string $version = null;

	#[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
	public ?int $maxPlayers = null;

	#[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
	public ?int $currentPlayers = null;

	#[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
	public ?bool $online = null;

	#[ORM\Column(length: 255, nullable: true)]
	public ?string $motdFirstLine = null;

	#[ORM\Column(length: 255, nullable: true)]
	public ?string $motdSecondLine = null;

	#[ORM\Column(type: Types::TEXT, nullable: true)]
	public ?string $icon = null;

	#[ORM\OneToMany(targetEntity: ServerStatistic::class, mappedBy: 'server', fetch: 'EXTRA_LAZY')]
	#[OrderBy(['createdAt' => 'ASC'])]
	private Collection $serverStatistics;

	#[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
	public DateTimeImmutable $createdAt;

	#[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
	public DateTime $updatedAt;

	public function __construct()
	{
		$this->serverStatistics = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	#[ORM\PrePersist]
	public function setCreatedAtValue(): void
	{
		$this->createdAt = new DateTimeImmutable();
	}

	#[ORM\PrePersist]
	#[ORM\PreUpdate]
	public function setUpdatedAtValue(): void
	{
		$this->updatedAt = new DateTime();
	}

	/**
	 * @return Collection<int, ServerStatistic>
	 */
	public function getServerStatistics(): Collection
	{
		return $this->serverStatistics;
	}
}

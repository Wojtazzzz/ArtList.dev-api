<?php

namespace App\Modules\Servers\Infrastructure\Entities;

use App\Modules\Servers\Infrastructure\Repositories\ServerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServerRepository::class)]
#[ORM\Table(name: 'server')]
class Server
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $ip = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $version = null;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private ?string $maxPlayers = null;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private ?int $currentPlayers = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private ?bool $online = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motdFirstLine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motdSecondLine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?string $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?string $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}

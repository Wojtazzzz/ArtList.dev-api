<?php

declare(strict_types=1);

namespace App\Modules\Servers\Infrastructure\Repositories;

use App\Modules\Servers\Domain\Entities\Server as DomainServerEntity;
use App\Modules\Servers\Infrastructure\Entities\Server;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Server>
 */
class ServerRepository extends ServiceEntityRepository implements \App\Modules\Servers\Domain\Repositories\ServerRepository
{
	public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $entityManager)
	{
		parent::__construct($registry, Server::class);
	}

	public function getPaginatedServers(int $page, int $limit, ?string $order, ?string $name): array
	{
		[$field, $direction] = match ($order) {
			'name' => ['name', 'ASC'],
			'-name' => ['name', 'DESC'],
			'players' => ['currentPlayers', 'ASC'],
			default => ['currentPlayers', 'DESC'],
		};

		$builder = $this->createQueryBuilder('s')
			->select(
				's.id',
				's.name',
				's.online',
				's.icon',
				's.version',
				's.currentPlayers',
				's.maxPlayers',
				's.motdFirstLine',
				's.motdSecondLine',
			)
			->setFirstResult(max(0, $page * $limit - $limit))
			->setMaxResults(max(1, $limit))
			->orderBy("s.{$field}", $direction);

		if ($name) {
			$lowerName = mb_strtolower($name);

			$builder->andWhere("LOWER(s.name) LIKE :name")
				->setParameter("name", "%{$lowerName}%");
		}

		return $builder->getQuery()->getResult();
	}

	public function existsByName(string $name): bool
	{
		return (bool)$this->createQueryBuilder('s')
			->andWhere('LOWER(s.name) = :name')
			->setParameter('name', mb_strtolower($name))
			->getQuery()
			->setMaxResults(1)
			->getResult();
	}

	public function create(DomainServerEntity $server): void
	{
		$entity = new Server();
		$entity->name = $server->name;
		$entity->icon = $server->icon;
		$entity->motdFirstLine = $server->motd->firstLine;
		$entity->motdSecondLine = $server->motd->secondLine;
		$entity->currentPlayers = $server->players->currentPlayers;
		$entity->maxPlayers = $server->players->maxPlayers;
		$entity->online = $server->online;
		$entity->version = $server->version;

		$this->entityManager->persist($entity);
		$this->entityManager->flush();
	}

	public function getToUpdate()
	{
		return $this->createQueryBuilder('s')
			->select('s.id', 's.name')
			->setMaxResults(500)
			->getQuery()
			->getResult();
	}

	public function update(int $id, DomainServerEntity $server): void
	{
		$entity = $this->getEntityManager()->getRepository(Server::class)->find($id);

		$entity->name = $server->name;
		$entity->icon = $server->icon;
		$entity->motdFirstLine = $server->motd->firstLine;
		$entity->motdSecondLine = $server->motd->secondLine;
		$entity->currentPlayers = $server->players->currentPlayers;
		$entity->maxPlayers = $server->players->maxPlayers;
		$entity->online = $server->online;
		$entity->version = $server->version;

		$this->entityManager->flush();
	}

	public function getCount(): int
	{
		return $this->getEntityManager()->getRepository(Server::class)->count();
	}

	public function markAsOffline(int $id): void
	{
		$entity = $this->getEntityManager()->getRepository(Server::class)->find($id);

		$entity->currentPlayers = 0;
		$entity->online = false;

		$this->entityManager->flush();
	}

	public function getByName(string $name): Server|null
	{
		return $this->createQueryBuilder('s')
			->andWhere("LOWER(s.name) LIKE :name")
			->setParameter("name", mb_strtolower($name))
			->setMaxResults(1)
			->getQuery()
			->getOneOrNullResult();
	}
}

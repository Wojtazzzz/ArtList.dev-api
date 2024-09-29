<?php

declare(strict_types=1);

namespace App\Modules\Servers\Infrastructure\Repositories;

use App\Modules\Servers\Domain\Entities\Server as DomainServerEntity;
use App\Modules\Servers\Infrastructure\Entities\Server;
use App\Modules\Servers\Infrastructure\Entities\ServerStatistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServerStatistic>
 */
class ServerStatisticRepository extends ServiceEntityRepository implements \App\Modules\Servers\Domain\Repositories\ServerStatisticRepository
{
	public function __construct(
		ManagerRegistry $registry,
		private readonly EntityManagerInterface $entityManager
	)
	{
		parent::__construct($registry, ServerStatistic::class);
	}

	/**
	 * @throws ORMException
	 */
	public function create(DomainServerEntity $data): void
	{
		if (!$serverId = $data->id) {
			$serverId = $this->entityManager
				->getRepository(Server::class)
				->findOneBy(['name' => $data->name])
				->getId();
		}

		$serverEntity = $this->entityManager->getReference(Server::class, $serverId);

		$entity = new ServerStatistic();
		$entity->online = $data->online;
		$entity->players = (int)$data->players?->currentPlayers;
		$entity->setServer($serverEntity);

		$this->entityManager->persist($entity);
		$this->entityManager->flush();
	}

	public function getLastForServer(int $serverId): mixed
	{
		return $this->createQueryBuilder('s')
			->select('s.id', 's.createdAt')
			->where('s.server = :serverId')
			->setParameter('serverId', $serverId)
			->orderBy('s.createdAt', 'DESC')
			->setMaxResults(1)
			->getQuery()
			->getOneOrNullResult();
	}

	public function deleteOlderThanMonth(): void
	{
		$this->createQueryBuilder('s')
			->where('s.createdAt < :date')
			->setParameter('date', (new \DateTime())->modify('-1 month'))
			->delete()
			->getQuery()
			->execute();
	}
}

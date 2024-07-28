<?php

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

    public function getPaginatedServers(int $page, int $limit, ?string $order, ?string $name)
    {
        [$field, $direction] = match ($order) {
            'name' => ['name', 'ASC'],
            '-name' => ['name', 'DESC'],
            'players' => ['currentPlayers', 'ASC'],
            default => ['currentPlayers', 'DESC'],
        };

        $builder = $this->createQueryBuilder('s')
            ->setFirstResult(max(0, $page * $limit - $limit))
            ->setMaxResults(max(1, $limit))
            ->orderBy("s.{$field}", $direction);

        if ($name) {
            $lowerName = strtolower($name);

            $builder->andWhere("LOWER(s.name) LIKE :name")
                ->setParameter("name", "%{$lowerName}%");
        }

        return $builder->getQuery()->getResult();
    }

    public function existsByName(string $name): bool
    {
        return (bool)$this->createQueryBuilder('s')
            ->andWhere('s.name = :name')
            ->setParameter('name', $name)
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


    public function getAllToUpdate()
    {
        return $this->createQueryBuilder('s')
            ->select('s.id', 's.name')
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
}

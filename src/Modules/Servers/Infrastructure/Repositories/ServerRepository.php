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

    public function getPaginatedServers(int $page, int $limit)
    {
        return $this->createQueryBuilder('s')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Server[] Returns an array of Server objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Server
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }\

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
}

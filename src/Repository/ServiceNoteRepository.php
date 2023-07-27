<?php

namespace App\Repository;

use App\Entity\ServiceNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceNote>
 *
 * @method ServiceNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceNote[]    findAll()
 * @method ServiceNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceNote::class);
    }

    public function save(ServiceNote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ServiceNote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLatestServiceNote(): ServiceNote
    {
        return $this->createQueryBuilder('sn')
            ->orderBy('sn.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
}

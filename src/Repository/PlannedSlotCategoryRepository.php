<?php

namespace App\Repository;

use App\Entity\PlannedSlotCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlannedSlotCategory>
 *
 * @method PlannedSlotCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlannedSlotCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlannedSlotCategory[]    findAll()
 * @method PlannedSlotCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlannedSlotCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlannedSlotCategory::class);
    }

    public function save(PlannedSlotCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PlannedSlotCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PlannedSlotCategory[] Returns an array of PlannedSlotCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlannedSlotCategory
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\ExpedienteItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpedienteItem>
 *
 * @method ExpedienteItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpedienteItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpedienteItem[]    findAll()
 * @method ExpedienteItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpedienteItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpedienteItem::class);
    }

//    /**
//     * @return ExpedienteItem[] Returns an array of ExpedienteItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExpedienteItem
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

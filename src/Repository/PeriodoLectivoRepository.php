<?php

namespace App\Repository;

use App\Entity\PeriodoLectivo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PeriodoLectivo>
 *
 * @method PeriodoLectivo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PeriodoLectivo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PeriodoLectivo[]    findAll()
 * @method PeriodoLectivo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeriodoLectivoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PeriodoLectivo::class);
    }

//    /**
//     * @return PeriodoLectivo[] Returns an array of PeriodoLectivo objects
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

//    public function findOneBySomeField($value): ?PeriodoLectivo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

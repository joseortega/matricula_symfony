<?php

namespace App\Repository;

use App\Entity\Paralelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Paralelo>
 *
 * @method Paralelo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paralelo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paralelo[]    findAll()
 * @method Paralelo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParaleloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paralelo::class);
    }

//    /**
//     * @return Paralelo[] Returns an array of Paralelo objects
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

//    public function findOneBySomeField($value): ?Paralelo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

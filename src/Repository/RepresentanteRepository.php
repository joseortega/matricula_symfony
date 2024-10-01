<?php

namespace App\Repository;

use App\Entity\Representante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Representante>
 *
 * @method Representante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Representante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Representante[]    findAll()
 * @method Representante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepresentanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Representante::class);
    }

//    /**
//     * @return Representante[] Returns an array of Representante objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Representante
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    
    public function findAllQuery($filter): array{
        $qb = $this->createQueryBuilder('r')
           ->andWhere('r.nombres LIKE :query')
           ->orWhere('r.apellidos LIKE :query')
           ->orWhere('r.identificacion LIKE :query')
           ->setParameter('query', '%'.$filter.'%')
           ->orderBy('r.nombres', 'ASC')
           ->getQuery();

        return $qb->execute();
    }
    
    public function search($filter): array{
        $qb = $this->createQueryBuilder('representante')
           ->andWhere('representante.nombres LIKE :query')
           ->orWhere('representante.apellidos LIKE :query')
           ->orWhere('representante.identificacion LIKE :query')
           ->setParameter('query', '%'.$filter.'%')
           ->orderBy('representante.nombres', 'ASC')
           ->getQuery();

        return $qb->execute();
    }
}

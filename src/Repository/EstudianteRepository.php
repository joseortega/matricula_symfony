<?php

namespace App\Repository;

use App\Entity\Estudiante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Estudiante>
 *
 * @method Estudiante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estudiante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estudiante[]    findAll()
 * @method Estudiante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstudianteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estudiante::class);
    }

//    /**
//     * @return Estudiante[] Returns an array of Estudiante objects
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

//    public function findOneBySomeField($value): ?Estudiante
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    
    public function findAllQuery($filter): array{
        $qb = $this->createQueryBuilder('e')
           ->andWhere('e.nombres LIKE :query')
           ->orWhere('e.apellidos LIKE :query')
           ->orWhere('e.identificacion LIKE :query')
           ->setParameter('query', '%'.$filter.'%')
           ->orderBy('e.nombres', 'ASC')
           ->getQuery();

        return $qb->execute();
    }
    
    public function findOneByIdentificacion($identificacion): ?Estudiante
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.identificacion = :identificacion')
            ->setParameter('identificacion', $identificacion)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function search($filter): array{
        $qb = $this->createQueryBuilder('e')
           ->andWhere('e.nombres LIKE :query')
           ->orWhere('e.apellidos LIKE :query')
           ->orWhere('e.identificacion LIKE :query')
           ->setParameter('query', '%'.$filter.'%')
           ->orderBy('e.nombres', 'ASC')
           ->setMaxResults(5)
           ->getQuery();

        return $qb->execute();
    }
}

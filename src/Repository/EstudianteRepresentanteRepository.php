<?php

namespace App\Repository;

use App\Entity\EstudianteRepresentante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EstudianteRepresentante>
 */
class EstudianteRepresentanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstudianteRepresentante::class);
    }

    /**
     * @return EstudianteRepresentante[] Returns an array of EstudianteRepresentante objects
     */
    public function findByEstudianteId(int $estudianteId): array
    {
        return $this->createQueryBuilder('estudianteRepresentante')
            ->andWhere('estudianteRepresentante.estudiante = :estudiante')
            ->setParameter('estudiante', $estudianteId)
            ->orderBy('estudianteRepresentante.esPrincipal', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByEstudiantePrincipal(int $estudianteId): array
    {
        $estudianteRepresentantes = $this->createQueryBuilder('estudianteRepresentante')
            ->andWhere('estudianteRepresentante.estudiante = :estudiante')
            ->setParameter('estudiante', $estudianteId)
            ->orderBy('estudianteRepresentante.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;

        return $estudianteRepresentantes;
    }
    
    public function findByEstudiantePrincipalOne(int $estudianteId): ?EstudianteRepresentante
    {
        $estudianteRepresentante = $this->createQueryBuilder('estudianteRepresentante')
            ->andWhere('estudianteRepresentante.estudiante = :estudiante')
            ->setParameter('estudiante', $estudianteId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;

        return $estudianteRepresentante;
    }

    public function findByEstdudianteExceptRepresentanteOne(int $estudianteId, int $id): ?EstudianteRepresentante
    {
        $estudianteRepresentante = $this->createQueryBuilder('estudianteRepresentante')
            ->where('estudianteRepresentante.estudiante = :estudiante')
            ->andWhere('estudianteRepresentante.id != :id')
            ->andWhere('estudianteRepresentante.esPrincipal = true')
            ->setParameter('estudiante', $estudianteId)
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $estudianteRepresentante;
        }
}

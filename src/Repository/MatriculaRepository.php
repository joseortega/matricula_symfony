<?php

namespace App\Repository;

use App\Entity\Matricula;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matricula>
 *
 * @method Matricula|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matricula|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matricula[]    findAll()
 * @method Matricula[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatriculaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matricula::class);
    }

//    /**
//     * @return Matricula[] Returns an array of Matricula objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Matricula
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findAllQuery(
        $periodoLectivoId = null,
        $gradoEscolarId = null,
        $paraleloId = null,
        $estado = '',
        $searchTerm = '')
    {
        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.estudiante', 'e');

        if ($periodoLectivoId !== null) {
            $qb->andWhere('m.periodoLectivo = :periodo_lectivo')
               ->setParameter('periodo_lectivo', $periodoLectivoId);
        }

        if ($gradoEscolarId !== null) {
            $qb->andWhere('m.gradoEscolar = :grado_escolar')
                ->setParameter('grado_escolar', $gradoEscolarId);
        }

        if ($paraleloId !== null) {
            $qb->andWhere('m.paralelo = :paralelo')
                ->setParameter('paralelo', $paraleloId);
        }

        if (!empty($estado)) {
            $qb->andWhere('m.estado = :estado')
                ->setParameter('estado', $estado);
        }

        if (!empty($searchTerm)) {
            $qb->andWhere('e.nombres LIKE :search_term OR e.apellidos LIKE :search_term OR e.identificacion LIKE :search_term')
               ->setParameter('search_term', '%' . $searchTerm . '%');
        }

        // Obtén el Query a partir del QueryBuilder
        return $qb->getQuery();
    }
}

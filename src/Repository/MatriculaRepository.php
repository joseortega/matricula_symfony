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
public function findAllQuery($filter): array{
        $qb = $this->createQueryBuilder('m')
                ->innerJoin('m.estudiante', 'e')
           ->orderBy('m.fecha', 'ASC')
            ->getQuery();

        return $qb->execute();
    }
    
    public function findAllQuery2($filter): array {
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery("SELECT m FROM App\Entity\Matricula  m INNER JOIN m.estudiante e");
        $query->setMaxResults(5);
        
        return $query->execute();
    }
    
    public function findAllQuery3($gradoEscolarId = null, $periodoLectivoId=null,  $searchTerm = '')
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT m
            FROM App\Entity\Matricula m
            JOIN m.estudiante e
            WHERE m.gradoEscolar = :grado_escolar
            AND m.periodoLectivo = :periodo_lectivo
            AND (e.nombres LIKE :search OR e.apellidos LIKE :search OR e.identificacion LIKE :search)'
        )
                
        ->setParameter('grado_escolar', $gradoEscolarId)
        ->setParameter('periodo_lectivo', $periodoLectivoId)
        ->setParameter('search', '%' . $searchTerm . '%');

        return $query->execute();
    }
    
    public function findAllQuery4($gradoEscolarId = null, $periodoLectivoId = null, $searchTerm = '')
    {
        // Obtén el EntityManager y crea un QueryBuilder para la entidad 'Matricula'
        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.estudiante', 'e');

        // Agrega condiciones opcionalmente basadas en la presencia de los parámetros
        if ($gradoEscolarId !== null) {
            $qb->andWhere('m.gradoEscolar = :grado_escolar')
               ->setParameter('grado_escolar', $gradoEscolarId);
        }

        if ($periodoLectivoId !== null) {
            $qb->andWhere('m.periodoLectivo = :periodo_lectivo')
               ->setParameter('periodo_lectivo', $periodoLectivoId);
        }

        if (!empty($searchTerm)) {
            $qb->andWhere('e.nombres LIKE :search_term OR e.apellidos LIKE :search_term OR e.identificacion LIKE :search_term')
               ->setParameter('search_term', '%' . $searchTerm . '%');
        }

        // Obtén el Query a partir del QueryBuilder y ejecuta la consulta
        return $qb->getQuery()->execute();
    }
}

<?php

namespace App\Repository;

use App\Entity\Matricula;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;


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

    public function findAllQuery(
        $periodoLectivoId = null,
        $gradoEscolarId = null,
        $paraleloId = null,
        $estadoMatriculasIds = null,
        $searchTerm = '',
        $withRepresentante = false)
    {
        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.estudiante', 'e')
            ->orderBy('e.apellidos', 'ASC'); // Ordenar por apellidos ascendente

        // Aplicar filtros comunes
        $this->applyFilters($qb, $periodoLectivoId, $gradoEscolarId, $paraleloId, $estadoMatriculasIds, $searchTerm);

        return $qb->getQuery();
    }

    public function findAllWhitRepresentanteQuery(
        $periodoLectivoId = null,
        $gradoEscolarId = null,
        $paraleloId = null,
        $estadoMatriculasIds = null,
        $searchTerm = '')
    {

        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.estudiante', 'e')
            ->leftJoin('e.estudianteRepresentantes', 'er')
            ->leftJoin('er.representante', 'r')
            ->leftJoin('e.expediente', 'exp') // ← FALTA ESTA RELACIÓN
            ->leftJoin('e.uniformeTalla', 'ut') // ← FALTA ESTA RELACIÓN
            ->leftJoin('e.paisNacionalidad', 'pn') // ← SI EXISTE
            ->leftJoin('m.periodoLectivo', 'pl') // ← FALTA ESTA RELACIÓN
            ->leftJoin('m.gradoEscolar', 'ge') // ← FALTA ESTA RELACIÓN
            ->leftJoin('m.estadoMatricula', 'em') // ← FALTA ESTA RELACIÓN
            ->leftJoin('m.paralelo', 'par') // ← SI EXISTE
            ->leftJoin('m.jornada', 'jor') // ← SI EXISTE
            ->leftJoin('m.modalidad', 'mod') // ← SI EXISTE
            ->addSelect('e', 'er', 'r', 'exp', 'ut', 'pl', 'ge', 'em', 'par', 'jor', 'mod')
            ->orderBy('e.apellidos', 'ASC');

        // Aplicar filtros comunes
        $this->applyFilters($qb, $periodoLectivoId, $gradoEscolarId, $paraleloId, $estadoMatriculasIds, $searchTerm);

        return $qb->getQuery();
    }

    private function applyFilters(QueryBuilder $qb,
                                   $periodoLectivoId = null,
                                   $gradoEscolarId = null,
                                   $paraleloId = null,
                                   $estadoMatriculasIds = null,
                                   $searchTerm = '')
    {
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

        if (!empty($estadoMatriculasIds)) {
            $qb->andWhere('m.estadoMatricula IN (:estado_matriculas)')
                ->setParameter('estado_matriculas', $estadoMatriculasIds);
        }

        if (!empty($searchTerm)) {
            $qb->andWhere('e.nombres LIKE :search_term OR e.apellidos LIKE :search_term OR e.identificacion LIKE :search_term')
                ->setParameter('search_term', '%' . $searchTerm . '%');
        }
    }
}

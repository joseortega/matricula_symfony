<?php

namespace App\DataFixtures;

use App\Entity\PeriodoLectivo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class PeriodoLectivoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Periodo Lectivo
        $periodoLectivo = new PeriodoLectivo();
        $periodoLectivo->setDescripcion("2023-2024");
        $periodoLectivo->setFechaInicio(new \DateTime('2023-09-01'));
        $periodoLectivo->setFechaFin(new \DateTime('2024-08-31'));
        $periodoLectivo->setHabilitadoParaMatricula(false);
        $manager->persist($periodoLectivo);

        $periodoLectivo2 = new PeriodoLectivo();
        $periodoLectivo2->setDescripcion("2024-2025");
        $periodoLectivo2->setFechaInicio(new \DateTime('2024-09-01'));
        $periodoLectivo2->setFechaFin(new \DateTime('2025-08-31'));
        $periodoLectivo2->setHabilitadoParaMatricula(true);
        $manager->persist($periodoLectivo2);

        $manager->flush();
    }
}

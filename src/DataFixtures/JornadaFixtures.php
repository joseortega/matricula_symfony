<?php

namespace App\DataFixtures;

use App\Entity\Jornada;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class JornadaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Jornadas
        $jornada = new Jornada();
        $jornada->setDescripcion("Matutina");
        $manager->persist($jornada);

        $jornada2 = new Jornada();
        $jornada2->setDescripcion("Vespertina");
        $manager->persist($jornada2);

        $jornada3 = new Jornada();
        $jornada3->setDescripcion("Diurno");
        $manager->persist($jornada3);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Modalidad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ModalidadFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //modalidad
        $modalidad = new Modalidad();
        $modalidad->setDescripcion("Presencial");
        $manager->persist($modalidad);

        $modalidad2 = new Modalidad();
        $modalidad2->setDescripcion("Semipresencial");
        $manager->persist($modalidad2);

        $modalidad3= new Modalidad();
        $modalidad3->setDescripcion("Distancia");
        $manager->persist($modalidad3);

        $manager->flush();
    }
}

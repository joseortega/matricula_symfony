<?php

namespace App\DataFixtures;

use App\Entity\Paralelo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ParaleloFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //paralelo
        $paralelo = new Paralelo();
        $paralelo->setDescripcion("A");
        $manager->persist($paralelo);

        $paralelo2 = new Paralelo();
        $paralelo2->setDescripcion("B");
        $manager->persist($paralelo2);

        $paralelo3 = new Paralelo();
        $paralelo3->setDescripcion("C");
        $manager->persist($paralelo3);

        $manager->flush();
    }
}

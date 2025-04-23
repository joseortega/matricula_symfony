<?php

namespace App\DataFixtures;

Use App\Entity\UniformeTalla;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class UniformeTallaFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        //tallas de uniforme
        $uniformeTalla1 = new UniformeTalla();
        $uniformeTalla1->setDescripcion("4");
        $manager->persist($uniformeTalla1);
        
        $uniformeTalla2 = new UniformeTalla();
        $uniformeTalla2->setDescripcion("6");
        $manager->persist($uniformeTalla2);
        
        $uniformeTalla3 = new UniformeTalla();
        $uniformeTalla3->setDescripcion("8");
        $manager->persist($uniformeTalla3);
        
        $uniformeTalla4 = new UniformeTalla();
        $uniformeTalla4->setDescripcion("10");
        $manager->persist($uniformeTalla4);
        
        $uniformeTalla5 = new UniformeTalla();
        $uniformeTalla5->setDescripcion("12");
        $manager->persist($uniformeTalla5);
        
        $uniformeTalla6 = new UniformeTalla();
        $uniformeTalla6->setDescripcion("14");
        $manager->persist($uniformeTalla6);
        
        $uniformeTalla7 = new UniformeTalla();
        $uniformeTalla7->setDescripcion("16");
        $manager->persist($uniformeTalla7);
        
        $uniformeTalla8 = new UniformeTalla();
        $uniformeTalla8->setDescripcion("18");
        $manager->persist($uniformeTalla8);
        
        $uniformeTalla9 = new UniformeTalla();
        $uniformeTalla9->setDescripcion("20");
        $manager->persist($uniformeTalla9);
       
        $manager->flush();
    }
}

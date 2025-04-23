<?php

namespace App\DataFixtures;

Use App\Entity\Parentesco;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ParentescoFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        //Parentesco
        $parentesco = new Parentesco();
        $parentesco->setDescripcion('Padre');
        $manager->persist($parentesco);
        
        $parentesco2 = new Parentesco();
        $parentesco2->setDescripcion('Madre');
        $manager->persist($parentesco2);
        
        $parentesco3 = new Parentesco();
        $parentesco3->setDescripcion('Tio(a)');
        $manager->persist($parentesco3);
        
        $parentesco4 = new Parentesco();
        $parentesco4->setDescripcion('Hermano(a)');
        $manager->persist($parentesco4);
        
        $manager->flush();
    }
}

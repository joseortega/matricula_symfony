<?php

namespace App\DataFixtures;

Use App\Entity\Nivel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class NivelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //nivel
        $nivel1 = new Nivel();
        $nivel1->setDescripcion("EDUCACION INICIAL");
        $manager->persist($nivel1);
        
        $this->addReference('INICIAL', $nivel1);
        
        $nivel2 = new Nivel();
        $nivel2->setDescripcion("EDUCACION GENERAL BASICA PREPARATORIA");
        $manager->persist($nivel2);
        
        $this->addReference('PREPARATORIA', $nivel2);
        
        $nivel3 = new Nivel();
        $nivel3->setDescripcion("EDUCACION GENERAL BASICA ELEMENTAL");
        $manager->persist($nivel3);
        
        $this->addReference('ELEMENTAL', $nivel3);
        
        $nivel4 = new Nivel();
        $nivel4->setDescripcion("EDUCACION GENERAL BASICA MEDIA");
        $manager->persist($nivel4);
        
        $this->addReference('MEDIA', $nivel4);
        
        $nivel5 = new Nivel();
        $nivel5->setDescripcion("EDUCACION GENERAL BASICA SUPERIOR");
        $manager->persist($nivel5);
        
        $this->addReference('SUPERIOR', $nivel5);
        
        $nivel6 = new Nivel();
        $nivel6->setDescripcion("BACHILLERATO GENERAL UNIFICADO");
        $manager->persist($nivel6);
        
        $this->addReference('BACHILLERATO', $nivel6);
        
        $manager->flush();
    }
}

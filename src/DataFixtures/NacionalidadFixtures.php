<?php

namespace App\DataFixtures;

Use App\Entity\Nacionalidad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class NacionalidadFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //nacionalidad
        $nacionalidad1 = new Nacionalidad();
        $nacionalidad1->setDescripcion("Ecuatoriano");
        $manager->persist($nacionalidad1);

        $this->setReference('ECUATORIANO', $nacionalidad1);
        
        $nacionalidad2 = new Nacionalidad();
        $nacionalidad2->setDescripcion("Peruano");
        $manager->persist($nacionalidad2);

        $this->setReference('PERUANO', $nacionalidad2);
        
        $nacionalidad3 = new Nacionalidad();
        $nacionalidad3->setDescripcion("Colombiano");
        $manager->persist($nacionalidad3);

        $this->setReference('COLOMBIANO', $nacionalidad3);
        
        $nacionalidad4 = new Nacionalidad();
        $nacionalidad4->setDescripcion("Mexicano");
        $manager->persist($nacionalidad4);

        $this->setReference('MEXICANO', $nacionalidad4);
       
        $manager->flush();
    }
}

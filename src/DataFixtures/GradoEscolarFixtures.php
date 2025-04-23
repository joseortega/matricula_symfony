<?php

namespace App\DataFixtures;

Use App\Entity\Nivel;
Use App\Entity\GradoEscolar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
USE App\DataFixtures\NivelFixtures;


class GradoEscolarFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            NivelFixtures::class,
        ];

    }

    public function load(ObjectManager $manager): void
    {
        //Grado Escolar
        $gradoEscolar = new GradoEscolar();
        $gradoEscolar->setNivel($this->getReference('INICIAL', Nivel::class));
        $gradoEscolar->setSecuencia(1);
        $gradoEscolar->setDescripcion('INICIAL 1');
        $manager->persist($gradoEscolar);

        $this->setReference('INICIAL_1', $gradoEscolar);

        $gradoEscolar2 = new GradoEscolar();
        $gradoEscolar2->setNivel($this->getReference('INICIAL', Nivel::class));
        $gradoEscolar2->setSecuencia(2);
        $gradoEscolar2->setDescripcion('INICIAL 2');
        $manager->persist($gradoEscolar2);

        $this->setReference('INICIAL_2', $gradoEscolar2);


        $gradoEscolar3 = new GradoEscolar();
        $gradoEscolar3->setNivel($this->getReference('PREPARATORIA', Nivel::class));
        $gradoEscolar3->setSecuencia(3);
        $gradoEscolar3->setDescripcion('1ER AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar3);

        $this->setReference('1RO_EGB', $gradoEscolar3);


        $gradoEscolar4 = new GradoEscolar();
        $gradoEscolar4->setNivel($this->getReference('ELEMENTAL', Nivel::class));
        $gradoEscolar4->setSecuencia(4);
        $gradoEscolar4->setDescripcion('2DO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar4);

        $this->setReference('2DO_EGB', $gradoEscolar4);

        $gradoEscolar5 = new GradoEscolar();
        $gradoEscolar5->setNivel($this->getReference('ELEMENTAL', Nivel::class));
        $gradoEscolar5->setSecuencia(5);
        $gradoEscolar5->setDescripcion('3RO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar5);

        $this->setReference('3RO_EGB', $gradoEscolar5);

        $gradoEscolar6 = new GradoEscolar();
        $gradoEscolar6->setNivel($this->getReference('ELEMENTAL', Nivel::class));
        $gradoEscolar6->setSecuencia(6);
        $gradoEscolar6->setDescripcion('4TO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar6);

        $this->setReference('4TO_EGB', $gradoEscolar6);

        $gradoEscolar7 = new GradoEscolar();
        $gradoEscolar7->setNivel($this->getReference('MEDIA', Nivel::class));
        $gradoEscolar7->setSecuencia(7);
        $gradoEscolar7->setDescripcion('5TO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar7);

        $this->setReference('5TO_EGB', $gradoEscolar7);

        $gradoEscolar8 = new GradoEscolar();
        $gradoEscolar8->setNivel($this->getReference('MEDIA', Nivel::class));
        $gradoEscolar8->setSecuencia(8);
        $gradoEscolar8->setDescripcion('6TO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar8);

        $this->setReference('6TO_EGB', $gradoEscolar8);

        $gradoEscolar9 = new GradoEscolar();
        $gradoEscolar9->setNivel($this->getReference('MEDIA', Nivel::class));
        $gradoEscolar9->setSecuencia(9);
        $gradoEscolar9->setDescripcion('7MO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar9);

        $this->setReference('7MO_EGB', $gradoEscolar9);

        $gradoEscolar10 = new GradoEscolar();
        $gradoEscolar10->setNivel($this->getReference('SUPERIOR', Nivel::class));
        $gradoEscolar10->setSecuencia(10);
        $gradoEscolar10->setDescripcion('8VO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar10);

        $this->setReference('8VO_EGB', $gradoEscolar10);

        $gradoEscolar11 = new GradoEscolar();
        $gradoEscolar11->setNivel($this->getReference('SUPERIOR', Nivel::class));
        $gradoEscolar11->setSecuencia(11);
        $gradoEscolar11->setDescripcion('9NO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar11);

        $this->setReference('9NO_EGB', $gradoEscolar11);

        $gradoEscolar12 = new GradoEscolar();
        $gradoEscolar12->setNivel($this->getReference('SUPERIOR', Nivel::class));
        $gradoEscolar12->setSecuencia(12);
        $gradoEscolar12->setDescripcion('10MO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar12);

        $this->setReference('10MO_EGB', $gradoEscolar12);

        $gradoEscolar13 = new GradoEscolar();
        $gradoEscolar13->setNivel($this->getReference('BACHILLERATO', Nivel::class));
        $gradoEscolar13->setSecuencia(13);
        $gradoEscolar13->setDescripcion('1ER AÑO DE BACHILLERATO GENERAL UNIFICADO');
        $manager->persist($gradoEscolar13);

        $this->setReference('1RO_BGU', $gradoEscolar13);

        $gradoEscolar14 = new GradoEscolar();
        $gradoEscolar14->setNivel($this->getReference('BACHILLERATO', Nivel::class));
        $gradoEscolar14->setSecuencia(14);
        $gradoEscolar14->setDescripcion('2DO AÑO DE BACHILLERATO GENERAL UNIFICADO');
        $manager->persist($gradoEscolar14);

        $this->setReference('2DO_BGU', $gradoEscolar14);

        $gradoEscolar15= new GradoEscolar();
        $gradoEscolar15->setNivel($this->getReference('BACHILLERATO', Nivel::class));
        $gradoEscolar15->setSecuencia(15);
        $gradoEscolar15->setDescripcion('3RO AÑO DE BACHILLERATO GENERAL UNIFICADO');
        $manager->persist($gradoEscolar15);

        $this->setReference('3RO_BGU', $gradoEscolar15);

        $manager->flush();
    }
}

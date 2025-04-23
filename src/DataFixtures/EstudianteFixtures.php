<?php

namespace App\DataFixtures;

Use App\Entity\Estudiante;
use App\Entity\Nacionalidad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
USE App\DataFixtures\NacionalidadFixtures;

class EstudianteFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            NacionalidadFixtures::class,
        ];

    }
    public function load(ObjectManager $manager): void
    {
        //Estudiante
        for ($i = 0; $i < 20; $i++) {
            $estudiante = new Estudiante();
            $estudiante->setApellidos('apellidos '.$i);
            $estudiante->setNombres('nombres '.$i);
            $estudiante->setIdentificacion('110445838'.$i);
            $estudiante->setSexo('Hombre');
            $estudiante->setFechaNacimiento(new \DateTime());
            $estudiante->setNacionalidad($this->getReference('ECUATORIANO', Nacionalidad::class));
            $estudiante->setTieneDiscapacidad(false);
            
            $manager->persist($estudiante);
        }
        
        $estudiante1 = new Estudiante();
        $estudiante1->setApellidos('ortega ambuludi');
        $estudiante1->setNombres('jose claudio');
        $estudiante1->setIdentificacion('110445859');
        $estudiante1->setSexo('Hombre');
        $estudiante1->setFechaNacimiento(new \DateTime());
        $estudiante1->setNacionalidad($this->getReference('PERUANO', Nacionalidad::class));
        $estudiante1->setTieneDiscapacidad(false);
            
        $manager->persist($estudiante1);
        
        $estudiante2 = new Estudiante();
        $estudiante2->setApellidos('martinez camacho');
        $estudiante2->setNombres('juan pablo');
        $estudiante2->setIdentificacion('110445865');
        $estudiante2->setSexo('Hombre');
        $estudiante2->setFechaNacimiento(new \DateTime());
        $estudiante2->setNacionalidad($this->getReference('COLOMBIANO', Nacionalidad::class));
        $estudiante2->setTieneDiscapacidad(false);
        
        $manager->persist($estudiante2);
        
        $manager->flush();




    }
}

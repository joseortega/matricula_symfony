<?php

namespace App\DataFixtures;

use App\Entity\Requisito;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class RequisitoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //requisito
        $requisito1 = new Requisito();
        $requisito1->setDescripcion('Copia de Cedula Estudiante');
        $manager->persist($requisito1);

        $this->setReference('CEDULA_ESTUDIANTE', $requisito1);

        $requisito2 = new Requisito();
        $requisito2->setDescripcion('Copia de cedula del Representante');
        $manager->persist($requisito2);

        $this->setReference('CEDULA_REPRESENTANTE', $requisito2);

        $requisito3 = new Requisito();
        $requisito3->setDescripcion('Carnet de Vacunación');
        $manager->persist($requisito3);

        $this->setReference('CARNET_VACUNACION', $requisito3);

        $requisito4 = new Requisito();
        $requisito4->setDescripcion('Certificado de Matricula Inicial 1');
        $manager->persist($requisito4);

        $this->setReference('CERTIFICADO_MATRICULA_INICIAL1', $requisito4);

        $requisito5 = new Requisito();
        $requisito5->setDescripcion('Certificado de Promoción Inicial 1');
        $manager->persist($requisito5);

        $this->setReference('CERTIFICADO_PROMOCION_INICIAL1', $requisito5);

        $requisito6 = new Requisito();
        $requisito6->setDescripcion('Certificado de Matricula Inicial 2');
        $manager->persist($requisito6);

        $this->setReference('CERTIFICADO_MATRICULA_INICIAL2', $requisito6);

        $requisito7 = new Requisito();
        $requisito7->setDescripcion('Certificado de Promoción Inicial 2');
        $manager->persist($requisito7);

        $this->setReference('CERTIFICADO_PROMOCION_INICIAL2', $requisito7);

        $requisito8 = new Requisito();
        $requisito8->setDescripcion('Certificado de Matricula 1ro EGB');
        $manager->persist($requisito8);

        $this->setReference('CERTIFICADO_MATRICULA_1RO_EGB', $requisito8);

        $requisito9 = new Requisito();
        $requisito9->setDescripcion('Certificado de Promoción 1ro EGB');
        $manager->persist($requisito9);

        $this->setReference('CERTIFICADO_PROMOCION_1RO_EGB', $requisito9);

        $requisito10 = new Requisito();
        $requisito10->setDescripcion('Certificado de Promoción 2do EGB');
        $manager->persist($requisito10);

        $this->setReference('CERTIFICADO_MATRICULA_2DO_EGB', $requisito10);

        $requisito11 = new Requisito();
        $requisito11->setDescripcion('Certificado de Promoción 2do EGB');
        $manager->persist($requisito11);

        $this->setReference('CERTIFICADO_PROMOCION_2DO_EGB', $requisito11);

        $manager->flush();
    }
}

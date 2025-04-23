<?php

namespace App\DataFixtures;

use App\Entity\GradoEscolar;
use App\Entity\Requisito;
use App\Entity\GradoEscolarRequisito;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\GradoEscolarFixtures;
use App\DataFixtures\RequisitoFixtures;


class GradoEscolarRequisitoFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            GradoEscolarFixtures::class,
            RequisitoFixtures::class
        ];

    }
    public function load(ObjectManager $manager): void
    {
        //GradoEscolarRequisito

        $gradoEscolarRequisito1 = new GradoEscolarRequisito();
        $gradoEscolarRequisito1->setGradoEscolar($this->getReference('INICIAL_1', GradoEscolar::class));
        $gradoEscolarRequisito1->setRequisito($this->getReference('CEDULA_ESTUDIANTE', Requisito::class));
        $gradoEscolarRequisito1->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito1);

        $gradoEscolarRequisito2 = new GradoEscolarRequisito();
        $gradoEscolarRequisito2->setGradoEscolar($this->getReference('INICIAL_1', GradoEscolar::class));
        $gradoEscolarRequisito2->setRequisito($this->getReference('CEDULA_REPRESENTANTE', Requisito::class));
        $gradoEscolarRequisito2->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito2);

        $gradoEscolarRequisito3 = new GradoEscolarRequisito();
        $gradoEscolarRequisito3->setGradoEscolar($this->getReference('INICIAL_1', GradoEscolar::class));
        $gradoEscolarRequisito3->setRequisito($this->getReference('CARNET_VACUNACION', Requisito::class));
        $gradoEscolarRequisito3->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito3);

        $gradoEscolarRequisito4 = new GradoEscolarRequisito();
        $gradoEscolarRequisito4->setGradoEscolar($this->getReference('INICIAL_2', GradoEscolar::class));
        $gradoEscolarRequisito4->setRequisito($this->getReference('CEDULA_ESTUDIANTE', Requisito::class));
        $gradoEscolarRequisito4->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito4);

        $gradoEscolarRequisito5 = new GradoEscolarRequisito();
        $gradoEscolarRequisito5->setGradoEscolar($this->getReference('INICIAL_2', GradoEscolar::class));
        $gradoEscolarRequisito5->setRequisito($this->getReference('CEDULA_REPRESENTANTE', Requisito::class));
        $gradoEscolarRequisito5->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito5);

        $gradoEscolarRequisito6 = new GradoEscolarRequisito();
        $gradoEscolarRequisito6->setGradoEscolar($this->getReference('INICIAL_2', GradoEscolar::class));
        $gradoEscolarRequisito6->setRequisito($this->getReference('CERTIFICADO_MATRICULA_INICIAL1', Requisito::class));
        $gradoEscolarRequisito6->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito6);

        $gradoEscolarRequisito7 = new GradoEscolarRequisito();
        $gradoEscolarRequisito7->setGradoEscolar($this->getReference('INICIAL_2', GradoEscolar::class));
        $gradoEscolarRequisito7->setRequisito($this->getReference('CERTIFICADO_PROMOCION_INICIAL1', Requisito::class));
        $gradoEscolarRequisito7->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito7);

        $manager->flush();
    }
}

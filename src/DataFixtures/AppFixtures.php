<?php

namespace App\DataFixtures;

Use App\Entity\Estudiante;
use App\Entity\GradoEscolarRequisito;
Use App\Entity\Nivel;
Use App\Entity\GradoEscolar;
Use App\Entity\Nacionalidad;
use App\Entity\Requisito;
Use App\Entity\UniformeTalla;
Use App\Entity\Modalidad;
Use App\Entity\Jornada;
Use App\Entity\PeriodoLectivo;
Use App\Entity\Paralelo;
Use App\Entity\Parentesco;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //nacionalidad
        $nacionalidad1 = new Nacionalidad();
        $nacionalidad1->setDescripcion("Ecuatoriano");
        $manager->persist($nacionalidad1);
        
        $nacionalidad2 = new Nacionalidad();
        $nacionalidad2->setDescripcion("Peruano");
        $manager->persist($nacionalidad2);
        
        $nacionalidad3 = new Nacionalidad();
        $nacionalidad3->setDescripcion("Colombiano");
        $manager->persist($nacionalidad3);
        
        $nacionalidad4 = new Nacionalidad();
        $nacionalidad4->setDescripcion("Mexicano");
        $manager->persist($nacionalidad4);
       
        $manager->flush();

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
        
        //nivel
        $nivel1 = new Nivel();
        $nivel1->setDescripcion("EDUCACION INICIAL");
        $manager->persist($nivel1);
        
        $nivel2 = new Nivel();
        $nivel2->setDescripcion("EDUCACION GENERAL BASICA PREPARATORIA");
        $manager->persist($nivel2);
        
        $nivel3 = new Nivel();
        $nivel3->setDescripcion("EDUCACION GENERAL BASICA ELEMENTAL");
        $manager->persist($nivel3);
        
        $nivel4 = new Nivel();
        $nivel4->setDescripcion("EDUCACION GENERAL BASICA MEDIA");
        $manager->persist($nivel4);
        
        $nivel5 = new Nivel();
        $nivel5->setDescripcion("EDUCACION GENERAL BASICA SUPERIOR");
        $manager->persist($nivel5);
        
        $nivel6 = new Nivel();
        $nivel6->setDescripcion("BACHILLERATO GENERAL UNIFICADO");
        $manager->persist($nivel6);
        
        $manager->flush();

        //Grado Escolar
        $gradoEscolar = new GradoEscolar();
        $gradoEscolar->setNivel($nivel1);
        $gradoEscolar->setSecuencia(1);
        $gradoEscolar->setDescripcion('INCIAL 1');
        $manager->persist($gradoEscolar);
        
        $gradoEscolar2 = new GradoEscolar();
        $gradoEscolar2->setNivel($nivel1);
        $gradoEscolar2->setSecuencia(2);
        $gradoEscolar2->setDescripcion('INCIAL 2');
        $manager->persist($gradoEscolar2);
        
        $gradoEscolar3 = new GradoEscolar();
        $gradoEscolar3->setNivel($nivel2);
        $gradoEscolar3->setSecuencia(3);
        $gradoEscolar3->setDescripcion('1ER AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar3);
        
        $gradoEscolar4 = new GradoEscolar();
        $gradoEscolar4->setNivel($nivel3);
        $gradoEscolar4->setSecuencia(4);
        $gradoEscolar4->setDescripcion('2DO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar4);
        
        $gradoEscolar5 = new GradoEscolar();
        $gradoEscolar5->setNivel($nivel3);
        $gradoEscolar5->setSecuencia(5);
        $gradoEscolar5->setDescripcion('3RO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar5);
        
        $gradoEscolar6 = new GradoEscolar();
        $gradoEscolar6->setNivel($nivel3);
        $gradoEscolar6->setSecuencia(6);
        $gradoEscolar6->setDescripcion('4TO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar6);
        
        $gradoEscolar7 = new GradoEscolar();
        $gradoEscolar7->setNivel($nivel4);
        $gradoEscolar7->setSecuencia(7);
        $gradoEscolar7->setDescripcion('5TO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar7);
        
        $gradoEscolar8 = new GradoEscolar();
        $gradoEscolar8->setNivel($nivel4);
        $gradoEscolar8->setSecuencia(8);
        $gradoEscolar8->setDescripcion('6TO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar8);
        
        $gradoEscolar9 = new GradoEscolar();
        $gradoEscolar9->setNivel($nivel4);
        $gradoEscolar9->setSecuencia(9);
        $gradoEscolar9->setDescripcion('7MO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar9);
        
        $gradoEscolar10 = new GradoEscolar();
        $gradoEscolar10->setNivel($nivel5);
        $gradoEscolar10->setSecuencia(10);
        $gradoEscolar10->setDescripcion('8VO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar10);
        
        $gradoEscolar11 = new GradoEscolar();
        $gradoEscolar11->setNivel($nivel5);
        $gradoEscolar11->setSecuencia(11);
        $gradoEscolar11->setDescripcion('9NO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar11);
        
        $gradoEscolar12 = new GradoEscolar();
        $gradoEscolar12->setNivel($nivel5);
        $gradoEscolar12->setSecuencia(12);
        $gradoEscolar12->setDescripcion('10MO AÑO DE EDUCACION GENERAL BASICA');
        $manager->persist($gradoEscolar12);
        
        $gradoEscolar13 = new GradoEscolar();
        $gradoEscolar13->setNivel($nivel6);
        $gradoEscolar13->setSecuencia(13);
        $gradoEscolar13->setDescripcion('1ER AÑO DE BACHILLERATO GENERAL UNIFICADO');
        $manager->persist($gradoEscolar13);
        
        $gradoEscolar14 = new GradoEscolar();
        $gradoEscolar14->setNivel($nivel6);
        $gradoEscolar14->setSecuencia(14);
        $gradoEscolar14->setDescripcion('2DO AÑO DE BACHILLERATO GENERAL UNIFICADO');
        $manager->persist($gradoEscolar14);
        
        $gradoEscolar15= new GradoEscolar();
        $gradoEscolar15->setNivel($nivel6);
        $gradoEscolar15->setSecuencia(15);
        $gradoEscolar15->setDescripcion('3RO AÑO DE BACHILLERATO GENERAL UNIFICADO');
        $manager->persist($gradoEscolar15);
        
        $manager->flush();
        
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
        
        //Jornadas
        $jornada = new Jornada();
        $jornada->setDescripcion("Matutina");
        $manager->persist($jornada);
        
        $jornada2 = new Jornada();
        $jornada2->setDescripcion("Vespertina");
        $manager->persist($jornada2);
        
        $jornada3 = new Jornada();
        $jornada3->setDescripcion("Diurno");
        $manager->persist($jornada3);
        
        $manager->flush();
        
        //Periodo Lectivo
        $periodoLectivo = new PeriodoLectivo();
        $periodoLectivo->setDescripcion("2022-2023");
        $periodoLectivo->setFechaInicio(new \DateTime('2023-09-01'));
        $periodoLectivo->setFechaFin(new \DateTime('2024-08-31'));
        $manager->persist($periodoLectivo);
        
        $periodoLectivo2 = new PeriodoLectivo();
        $periodoLectivo2->setDescripcion("2023-2024");
        $periodoLectivo2->setFechaInicio(new \DateTime('2023-09-01'));
        $periodoLectivo2->setFechaFin(new \DateTime('2024-08-31'));
        $manager->persist($periodoLectivo2);
        
        $manager->flush();
        
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

        //Estudiante
        for ($i = 0; $i < 20; $i++) {
            $estudiante = new Estudiante();
            $estudiante->setApellidos('apellidos '.$i);
            $estudiante->setNombres('nombres '.$i);
            $estudiante->setIdentificacion('110445838'.$i);
            $estudiante->setSexo('Hombre');
            $estudiante->setFechaNacimiento(new \DateTime());
            $estudiante->setNacionalidad($nacionalidad1);
            $estudiante->setTieneDiscapacidad(false);
            $estudiante->setLugarResidencia('Patuca');
            
            $manager->persist($estudiante);
        }
        
        $estudiante1 = new Estudiante();
        $estudiante1->setApellidos('ortega ambuludi');
        $estudiante1->setNombres('jose claudio');
        $estudiante1->setIdentificacion('110445859');
        $estudiante1->setSexo('Hombre');
        $estudiante1->setFechaNacimiento(new \DateTime());
        $estudiante1->setNacionalidad($nacionalidad2);
        $estudiante1->setTieneDiscapacidad(false);
        $estudiante1->setLugarResidencia('Patuca');
            
        $manager->persist($estudiante1);
        
        $estudiante2 = new Estudiante();
        $estudiante2->setApellidos('martinez camacho');
        $estudiante2->setNombres('juan pablo');
        $estudiante2->setIdentificacion('110445865');
        $estudiante2->setSexo('Hombre');
        $estudiante2->setFechaNacimiento(new \DateTime());
        $estudiante2->setNacionalidad($nacionalidad3);
        $estudiante2->setTieneDiscapacidad(false);
        $estudiante2->setLugarResidencia('Patuca');
        
        $manager->persist($estudiante2);
        
        $manager->flush();

        //requisito
        $requisito1 = new Requisito();
        $requisito1->setDescripcion('Copia de Cedula Estudiante');
        $manager->persist($requisito1);

        $requisito2 = new Requisito();
        $requisito2->setDescripcion('Copia de cedula del Representante');
        $manager->persist($requisito2);

        $requisito3 = new Requisito();
        $requisito3->setDescripcion('Carnet de Vacunación');
        $manager->persist($requisito3);

        $requisito4 = new Requisito();
        $requisito4->setDescripcion('Certificado de Matricula Inicial 1');
        $manager->persist($requisito4);

        $requisito5 = new Requisito();
        $requisito5->setDescripcion('Certificado de Promoción Inicial 1');
        $manager->persist($requisito5);

        $requisito6 = new Requisito();
        $requisito6->setDescripcion('Certificado de Matricula Inicial 2');
        $manager->persist($requisito6);

        $requisito7 = new Requisito();
        $requisito7->setDescripcion('Certificado de Promoción Inicial 2');
        $manager->persist($requisito7);

        $requisito8 = new Requisito();
        $requisito8->setDescripcion('Certificado de Matricula 1ro EGB');
        $manager->persist($requisito8);

        $requisito9 = new Requisito();
        $requisito9->setDescripcion('Certificado de Promoción 1ro EGB');
        $manager->persist($requisito9);

        $requisito10 = new Requisito();
        $requisito10->setDescripcion('Certificado de Promoción 2do EGB');
        $manager->persist($requisito10);

        $requisito11 = new Requisito();
        $requisito11->setDescripcion('Certificado de Promoción 2do EGB');
        $manager->persist($requisito11);

        $manager->flush();

        //GradoEscolarRequisito

        $gradoEscolarRequisito1 = new GradoEscolarRequisito();
        $gradoEscolarRequisito1->setGradoEscolar($gradoEscolar);
        $gradoEscolarRequisito1->setRequisito($requisito1);
        $gradoEscolarRequisito1->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito1);

        $gradoEscolarRequisito2 = new GradoEscolarRequisito();
        $gradoEscolarRequisito2->setGradoEscolar($gradoEscolar);
        $gradoEscolarRequisito2->setRequisito($requisito2);
        $gradoEscolarRequisito2->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito2);

        $gradoEscolarRequisito3 = new GradoEscolarRequisito();
        $gradoEscolarRequisito3->setGradoEscolar($gradoEscolar);
        $gradoEscolarRequisito3->setRequisito($requisito3);
        $gradoEscolarRequisito3->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito3);

        $gradoEscolarRequisito4 = new GradoEscolarRequisito();
        $gradoEscolarRequisito4->setGradoEscolar($gradoEscolar2);
        $gradoEscolarRequisito4->setRequisito($requisito1);
        $gradoEscolarRequisito4->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito4);

        $gradoEscolarRequisito5 = new GradoEscolarRequisito();
        $gradoEscolarRequisito5->setGradoEscolar($gradoEscolar2);
        $gradoEscolarRequisito5->setRequisito($requisito2);
        $gradoEscolarRequisito5->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito5);

        $gradoEscolarRequisito6 = new GradoEscolarRequisito();
        $gradoEscolarRequisito6->setGradoEscolar($gradoEscolar2);
        $gradoEscolarRequisito6->setRequisito($requisito3);
        $gradoEscolarRequisito6->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito6);

        $gradoEscolarRequisito7 = new GradoEscolarRequisito();
        $gradoEscolarRequisito7->setGradoEscolar($gradoEscolar2);
        $gradoEscolarRequisito7->setRequisito($requisito4);
        $gradoEscolarRequisito7->setEsObligatorio(true);

        $manager->persist($gradoEscolarRequisito7);

        $manager->flush();
    }
}

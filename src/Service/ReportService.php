<?php


namespace App\Service;

use App\Entity\EstudianteRepresentante;
use App\Entity\Expediente;
use App\Service\PDFService;
use App\Entity\Matricula;

/**
 * Description of Report
 *
 * @author joshe
 */
class ReportService {
    //put your code here
    public function __construct(
            private PDFService $pdfService,) {
    }
    
    public function printCertifidadoMatricula(Matricula $matricula) {
        
        $pdf = $this->pdfService->createPDF();

        $pdf->SetFont('helvetica', 'B', 18); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, 'CERTIFICADO DE MATRÍCULA', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        $parrafo1 ="
        <p style='text-align: justify; margin: 0;'>
            El <b>Lic. JOSE MIGUEL YANZA CHACHO</b> con número de cédula N° <b>1400721138</b>, en su rol de RECTOR de la UNIDAD EDUCATIVA HÉROES DEL CENEPA
        </p>";
        
        $pdf->SetFont('helvetica', '', 15); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 5, '', '', $parrafo1, 0, 1, 0, true, 'J', true);

        $pdf->SetFont('helvetica', 'B', 18); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, 'CERTIFICA', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        
        $parrafo2 ="
        <p style='text-align: justify; margin: 0; padding: 0;'>
            Que el estudiante <b>{$matricula->getEstudiante()}</b>
            con número de identificación <b>{$matricula->getEstudiante()->getIdentificacion()}</b>,
            ha sido matriculado en el <b>{$matricula->getGradoEscolar()}</b>,
            para el año lectivo <b>{$matricula->getPeriodoLectivo()}</b>
        </p>";
        
        $pdf->SetFont('helvetica', '', 15); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 5, '', '', $parrafo2, 0, 1, 0, true, 'J', true);
        
        $fechaActual = new \DateTime();
        $fechaString = $fechaActual->format('Y-m-d');
        
        $pdf->SetFont('helvetica', 'B', 15); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, "Fecha de Emisión: {$fechaString}", 0, 1, 'R', 0, '', 0, false, 'T', 'M');
        
        $pdf->SetFont('helvetica', 'B', 15); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, "Atentamente:", 0, 1, 'L', 0, '', 0, false, 'T', 'M');
        
        $pdf->Cell(0, 30, '', 0, 1, 'C'); // Espacio para la firma
        $pdf->Line(50, $pdf->GetY(), 160, $pdf->GetY()); // Línea horizontal (ajusta las coordenadas según sea necesario)

        $pdf->Cell(0, 10, 'Rector', 0, 1, 'C');

        return $pdf;   
    }

    public function printCertifidadoPreInscripción(Matricula $matricula) {

        $pdf = $this->pdfService->createPDF();

        $pdf->SetFont('helvetica', 'B', 18); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, 'CERTIFICADO DE PRE-INSCRIPCIÓN', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        $parrafo1 ="
        <p style='text-align: justify; margin: 0;'>
            El <b>Lic. JOSE MIGUEL YANZA CHACHO</b> con número de cédula N° <b>1400721138</b>, en su rol de RECTOR de la UNIDAD EDUCATIVA HÉROES DEL CENEPA
        </p>";

        $pdf->SetFont('helvetica', '', 15); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 5, '', '', $parrafo1, 0, 1, 0, true, 'J', true);

        $pdf->SetFont('helvetica', 'B', 18); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, 'CERTIFICA', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        $parrafo2 ="
        <p style='text-align: justify; margin: 0; padding: 0;'>
            Que el estudiante <b>{$matricula->getEstudiante()}</b>
            con número de identificación <b>{$matricula->getEstudiante()->getIdentificacion()}</b>,
            ha sido pre-inscrito en el <b>{$matricula->getGradoEscolar()}</b>,
            para el año lectivo <b>{$matricula->getPeriodoLectivo()}</b>
        </p>";

        $pdf->SetFont('helvetica', '', 15); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 5, '', '', $parrafo2, 0, 1, 0, true, 'J', true);

        $fechaActual = new \DateTime();
        $fechaString = $fechaActual->format('Y-m-d');

        $pdf->SetFont('helvetica', 'B', 15); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, "Fecha de Emisión: {$fechaString}", 0, 1, 'R', 0, '', 0, false, 'T', 'M');

        $pdf->SetFont('helvetica', 'B', 15); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, "Atentamente:", 0, 1, 'L', 0, '', 0, false, 'T', 'M');

        $pdf->Cell(0, 30, '', 0, 1, 'C'); // Espacio para la firma
        $pdf->Line(50, $pdf->GetY(), 160, $pdf->GetY()); // Línea horizontal (ajusta las coordenadas según sea necesario)

        $pdf->Cell(0, 10, 'Rector', 0, 1, 'C');

        return $pdf;
    }

    public function printCertifidadoMatriculaAsistencia(Matricula $matricula) {

        $pdf = $this->pdfService->createPDF();

        $pdf->SetFont('helvetica', 'B', 18); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, 'CERTIFICADO DE MATRÍCULA', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        $parrafo1 ="
        <p style='text-align: justify; margin: 0;'>
            El <b>Lic. JOSE MIGUEL YANZA CHACHO</b> con número de cédula N° <b>1400721138</b>, en su rol de RECTOR de la UNIDAD EDUCATIVA HÉROES DEL CENEPA
        </p>";

        $pdf->SetFont('helvetica', '', 15); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 5, '', '', $parrafo1, 0, 1, 0, true, 'J', true);

        $pdf->SetFont('helvetica', 'B', 18); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, 'CERTIFICA', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        $parrafo2 ="
        <p style='text-align: justify; margin: 0; padding: 0;'>
            Que el estudiante <b>{$matricula->getEstudiante()}</b>
            con número de identificación <b>{$matricula->getEstudiante()->getIdentificacion()}</b>,
            ha sido matriculado en el <b>{$matricula->getGradoEscolar()}</b>,
            para el año lectivo <b>{$matricula->getPeriodoLectivo()}</b>,
            y se encuentra asistiendo normalmente a clases hasta la presente fecha.
        </p>";

        $pdf->SetFont('helvetica', '', 15); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 5, '', '', $parrafo2, 0, 1, 0, true, 'J', true);

        $fechaActual = new \DateTime();
        $fechaString = $fechaActual->format('Y-m-d');

        $pdf->SetFont('helvetica', 'B', 15); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, "Fecha de Emisión: {$fechaString}", 0, 1, 'R', 0, '', 0, false, 'T', 'M');

        $pdf->SetFont('helvetica', 'B', 15); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, "Atentamente:", 0, 1, 'L', 0, '', 0, false, 'T', 'M');

        $pdf->Cell(0, 30, '', 0, 1, 'C'); // Espacio para la firma
        $pdf->Line(50, $pdf->GetY(), 160, $pdf->GetY()); // Línea horizontal (ajusta las coordenadas según sea necesario)

        $pdf->Cell(0, 10, 'Rector', 0, 1, 'C');

        return $pdf;
    }
    
    public function printCartaAutorizacion(Matricula $matricula, EstudianteRepresentante $estudianteRepresentantePrincipal) {
        
        $pdf = $this->pdfService->createPDF();
        
        // Establecer la fuente para el nombre de la inhstitución
        $pdf->SetFont('helvetica', 'B', 18); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, 'CARTA DE AUTORIZACIÓN', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        $fechaActual = new \DateTime();
        $fechaString = $fechaActual->format('Y-m-d');

        $contenido ="
        <p style='text-align: justify; margin: 0; padding: 0;'>
            Yo <b>{$estudianteRepresentantePrincipal->getRepresentante()}</b>
            con número de cedula <b>{$estudianteRepresentantePrincipal->getRepresentante()->getIdentificacion()}</b>
            por medio del presente documento confirmo que acepto el procedimiento de la institución educativa en pleno apego a los derechos de los niñas, niños y adolescentes para la revisión de la mochila escolar, el cual tiene por objeto que los alumnos no porten ni introduzcan cualquier objeto que sirva para ser utilizados para causar daño o que atenten contra la salud física o moral de mi representado o sus compañeros.
            Por tal motivo en calidad de representante legal me comprometo a revisar diariamente la mochila de mi representado en el hogar para tener la certeza que no introduzca objetos prohibidos.
        </p>
        <p style='text-align: justify; margin: 0; padding: 0;'>
            AUTORIZO SE REVISE LA MOCHILA de mi representado/a <b>{$matricula->getEstudiante()}</b>,
            con número de cédula <b>{$matricula->getEstudiante()->getIdentificacion()}</b>
            estudiante de <b>{$matricula->getGradoEscolar()}</b>
        </p>
        <p style='text-align: justify; margin: 0; padding: 0;'>
            La presente carta de autorización tiene una vigencia para el ciclo escolar <b>{$matricula->getPeriodoLectivo()}</b>
            Enterado de lo anterior, me comprometo a conocer, cumplir y respetar los compromisos que en esta carta adoptamos.
            Para constancia de lo acordado, se firma este documento en la UNIDAD EDUCATIVA HEROES DEL CENEPA, a los <b>{$fechaString}</b>
        </p>";
        
        $pdf->SetFont('helvetica', '', 15); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 5, '', '', $contenido, 0, 1, 0, true, 'J', true);
        
        $pdf->SetFont('helvetica', 'B', 15); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, "Atentamente:", 0, 1, 'L', 0, '', 0, false, 'T', 'M');

        $pdf->Cell(0, 30, '', 0, 1, 'C'); // Espacio para la firma
        $pdf->Line(50, $pdf->GetY(), 160, $pdf->GetY()); // Línea horizontal (ajusta las coordenadas según sea necesario)

        $pdf->Cell(0, 10, $estudianteRepresentantePrincipal->getRepresentante(), 0, 1, 'C');

        return $pdf;
    }
    
    public function printActaCompromiso(Matricula $matricula, EstudianteRepresentante $estudianteRepresentantePrincipal) {
        
        $pdf = $this->pdfService->createPDF();

        $titulo = "
            <p style='text-align: justify; margin: 0; padding: 0;'>
                ACTA DE ACUERDOS Y COMPROMISOS DEL PADRE, MADRE Y ESTUDIANTE DURANTE EL AÑO LECTIVO {$matricula->getPeriodoLectivo()}
            </p>";
        
        $pdf->SetFont('helvetica', 'B', 11); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 15, '', '', $titulo, 0, 1, 0, true, 'C', true);
        
        $fechaActual = new \DateTime();
        $fechaString = $fechaActual->format('Y-m-d');
        
        $contenido ="
        <p style='text-align: justify; margin: 0; padding: 0;'>
            Estimado padre, madre de familia o representante de la Unidad Educativa Héroes del Cenepa es importante que las normas se cumplan de acuerdo a la LOEI (Ley Orgánica de Educación Intercultural Bilingüe) bajo los cuales se fundamenta el accionar de nuestra Institución, sean conocidas, compartidas y cumplidas por toda la comunidad educativa, dichas normas son valores éticos y de convivencia social como son: respeto, consideración hacia todos los miembros de la comunidad educativa, cumplimiento de las normas de convivencia, cuidado del patrimonio institucional, respeto a la propiedad ajena, puntualidad, asistencia y aseo.
        </p>
        <p style='text-align: justify; margin: 0; padding: 0;'>
            1.	CUIDADO PATRIMONIAL. Los estudiantes deben cuidar y respetar el patrimonio institucional, cuidando el espacio verde como plantas, árboles, basureros que tiene la Institución. Proteger las aulas, pupitres, bancas y paredes de la Institución. Se tomará diferentes acciones educativas, disciplinarias si existen daños del patrimonio Institucional, es decir la reposición del bien del establecimiento (ventanales, bancas, paredes, puertas, baños, material didáctico, textos, bienes de los demás compañeros)<br>
            2.	RESPETO Y CONSIDERACIÓN A TODA LA COLECTIVIDAD EDUCATIVA. Los estudiantes deben respetar a los compañeros y compañeras, maestros y maestras, tratándolos por sus nombres y sin ultrajarlos con sobrenombres. Vivir en democracia respetando las ideas de todos. Practicar normas de cortesía y respeto sin agredirse física ni verbalmente y saludando o guiando a las personas mayores o ajenas que visiten el plantel. Cumplimiento de deberes, tareas y demás eventos que soliciten su presencia.<br>
            3.	PUNTUALIDAD Y ASISTENCIA. Los estudiantes deben ingresar puntualmente de lunes a viernes, la hora entrada es de 07h30 para todos los niveles y la salida para los estudiantes: de Inicial 12h30, de básica 12h45 y de bachillerato 13h25. Los padres de familia o representantes deben asistir puntualmente a las reuniones convocadas por el Rector(a) o Docente de aula, el día y la hora señalada, de no asistir, deberá sujetarse a los acuerdos de la mayoría. Los representantes deben dejar a su representado en la puerta de entrada de la Institución; igualmente esperarán en la puerta a la hora de salida. La atención a los padres de familia será de lunes a viernes de 07h15 a 07h30 y los días miércoles de 13h30 a 15h15 o según la indicación del Docente o Inspector.<br>
            4.	INASISTENCIA AL AULA. La inasistencia de los estudiantes de uno o dos días deben ser notificados inmediatamente a sus representantes legales, quienes deberán justificarlo, a más tardar hasta dos días después del retorno del estudiante a clase ante el Docente Tutor. Si la inasistencia excediera dos días continuos el representante legal del estudiante deberá justificar con la documentación respectiva ante el Inspector o la máxima autoridad del establecimiento. La asistencia a las actividades educativas es de carácter obligatorio y se debe cumplir dentro de las jornadas y horarios establecidos. Si las inasistencias injustificadas excedieran del 10% de una o más asignaturas, reprobarán dichas asignaturas (Art. 172 del Reglamento a la LOEI).<br>
            5.	RESPETO A LA PROPIEDAD AJENA. Los niños y niñas deben cuidar y respetar sus pertenencias sean estas útiles escolares, prendas de vestir o lonchera dentro y fuera del aula, en caso de hallazgo de algunos de estos elementos, se entregará al maestro para su devolución. Se prohíbe traer objetos como celulares, juegos, lectores de memorias, cantidades de dinero inadecuadas, armas corto punzantes y otros que estén fuera de la actividad educativa, se hará conocer a sus representantes este incumplimiento y se tomará diferentes acciones educativas disciplinarias, en forma escrita y se adjuntará a su expediente académico.<br>
            6.	PRESENTACIÓN PERSONAL CON UNIFORME. El uniforme de la Institución. El uso del uniforme es de carácter obligatorio por lo tanto los estudiantes deberán respetarlo inclusive cuando se realicen salidas didácticas. Dado que la vestimenta caracteriza expresamente la pertenencia del alumno al plantel. El padre de familia debe velar que su representado(a) cumpla con el correcto uso de los uniformes oficiales del Plantel para el diario o eventos cívicos, como también el que entrega el Ministerio de Educación y el de educación física, tanto interiores como exteriores. Recordando que los uniformes son:<br>
                • NIÑAS UNIFORME DE PARADA. Falda color azul marino, blusa blanca, manga corta con el logotipo de la Institución en el bolsillo y medias largas color blanco, zapatos negros y solo los días lunes, días cívicos o cuando la autoridad indique se asistirá con una cinta formando un lazo, color azul marino. En el cabello las niñas podrán utilizar accesorios color blancos o azul marino.<br>
                • NIÑOS UNIFORME DE PARADA. Pantalón color azul marino, camisa blanca manga corta con el logotipo de la Institución en el bolsillo, zapatos negros de cuero caña baja, correa negra con hebilla normal y solo los días lunes, días cívicos o cuando la autoridad indique se asistirá con una corbata de cuello, color azul marino.<br>
                • El uniforme del Gobierno deberán usarlo para Educación Física. En caso de poseer el uniforme deportivo del Plantel puede combinar su uso. No se aceptará el uso de casacas, chompas, correas, medias, zapatos que no correspondan a los de la Unidad Educativa.<br>
            7.	ASEO Y PRESENTACIÓN. Los y las estudiantes deben cuidar de su aseo personal: uniforme limpio y planchado, zapatos lustrados, cabello peinado y recogido. Los niños y jóvenes deben llevar uñas cortas, un corte de cabello normal, sin aretes o piercing; y las niñas y señoritas sin maquillaje tanto en las uñas como en el rostro y llevar el cabello recogido.  Así también deberá cuidar del aseo del establecimiento: depositar la basura en los basureros, no llevar alimentos a las aulas.<br>
            8.	CUMPLIMIENTO DE TAREAS Y ROL DE ESTUDIANTE. Los estudiantes deben cumplir con las actividades propuestas por el Docente, dentro y fuera del Establecimiento. Las tareas atrasadas se calificarán sobre 7 en caso de no haber la justificación válida y pertinente para ello el padre de familia deberá acudir periódicamente y cuando sea convocado al Plantel con el fin de mantenerse informado sobre la asistencia, comportamiento o enseñanza aprendizaje del hijo (a) o representado(a) con el fin de velar que cumplan con todas las responsabilidades estudiantiles.<br>
            9.	PARTICIPACIÓN. Colaborar con los representados para participar en danzas, música, teatro, banda de música, entrenamientos y otras actividades que la institución planifique con el objetivo de dejar en alto el nombre de la Institución.<br>
            10.	COLABORACIÓN DEL PADRE DE FAMILIA. Colaborar directamente con todas las actividades organizadas por el curso, la institución o por el Comité Central de PP. FF. Cumplir con las Disposiciones de: Directivos, Juntas de Cursos de Profesores, Junta General de Profesores Guías, Asamblea General del Comité Central de Padres de Familia (Cuotas) y cooperar en todos los acuerdos y actividades planificadas para el año lectivo. Brindar los materias y útiles escolares necesarios para la realización del proceso de enseñanza aprendizaje tanto en el Plantel como en el hogar. Colaborar con la Institución en todas las actividades planificadas, sean: deportivas, culturales, científicas, cívicas, sociales y con el programa de participación estudiantil.<br>
            11.	FALTAS DE LOS ESTUDIANTES (INDISCIPLINA). Controlar que su representado(a) no asista a la Unidad Educativa bajo los efectos de alcohol o drogas y de hacerlo no se permitirá su entrada al Establecimiento. Ante el problema de drogas, sustancias estupefacientes o psicotrópicas, alcohol, tabaco y otras que están destruyendo al ser humano hoy en día y en especial a los niños, adolescentes y jóvenes, el padre de familia se compromete a colaborar en la prevención del uso indebido de alcohol, tabaco y drogas para lo cual autoriza que se revise la mochila y otros artefactos de su representado(a) por parte de las autoridades internas de la Institución Educativa y de ser el caso con la presencia de agentes de la DINAPEN para que realicen controles permanentes por el bien de los estudiantes. Las sanciones tienen la finalidad de educar en la práctica de valores y disciplina para establecer límites claros que den seguridad y eficiencia, así como desarrollar actitudes de tolerancia y respeto, razón por la cual el padre de familia se compromete a acatar las acciones disciplinarias tomadas por las autoridades del plantel en contra de su representado de acuerdo a la LOEI y su reglamento: Art. 330 falta de los estudiantes, de acuerdo al Reglamento General de Educación Intercultural; Las faltas de los estudiantes son los que se establecen en el Art. 134 de la LOEI, estas pueden ser: leves, graves o muy graves y será sancionado de acuerdo al acto indisciplinario.<br>
        </p>
        <p style='text-align: justify; margin: 0; padding: 0;'>
            El Padre de Familia y Estudiante acepta que en caso de incumplimiento de estas normas y de esta carta de compromiso, se sujetará a las resoluciones y disposiciones que la Institución Educativa disponga.
        </p>
        <p style='text-align: justify; margin: 0; padding: 0;'>
            Para constancia de aceptación, libre y voluntariamente, suscribimos en unidad de acto en la parroquia Patuca a los {$fechaString}.
        </p>";
        
        $pdf->SetFont('helvetica', '', 9); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 5, '', '', $contenido, 0, 1, 0, true, 'J', true);
        
        $pdf->SetFont('helvetica', 'B', 11); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, "Atentamente:", 0, 1, 'L', 0, '', 0, false, 'T', 'M');

        $pdf->Cell(0, 30, '', 0, 1, 'C'); // Espacio para la firma
        $pdf->Line(50, $pdf->GetY(), 160, $pdf->GetY()); // Línea horizontal (ajusta las coordenadas según sea necesario)

        $pdf->Cell(0, 5, $estudianteRepresentantePrincipal->getRepresentante(), 0, 1, 'C');
        $pdf->Cell(0, 5, $estudianteRepresentantePrincipal->getRepresentante()->getIdentificacion(), 0, 1, 'C');

        return $pdf;    
    }

    public function printRetiroExpediente(Expediente $expediente, EstudianteRepresentante $estudianteRepresentantePrincipal) {

        $pdf = $this->pdfService->createPDF();

        $titulo = "
            <p style='text-align: justify; margin: 0; padding: 0;'>
                ACTA DE ENTREGA Y RECEPCIÓN DE EXPEDIENTE ACADÉMICO
            </p>";

        $pdf->SetFont('helvetica', 'B', 18); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 20, '', '', $titulo, 0, 1, 0, true, 'C', true);

        $fechaRetiro = $expediente->getFechaRetiro();
        $año  = $fechaRetiro->format('Y');
        $mes   = $fechaRetiro->format('m');
        $dia   = $fechaRetiro->format('d');
        $hora = $fechaRetiro->format('H:i');

        $contenido ="
        <p style='text-align: justify; margin: 0;'>
            En la secretaría de la institución <b> a los {$dia} dias del mes {$mes} del {$año}</b>
            siendo  <b>{$hora}</b>, el rector de la institución, hace la entrega del expediente académico del <b>estudiante:
            {$expediente->getEstudiante()}</b> con número de cedula <b>{$expediente->getEstudiante()->getIdentificacion()}</b>
            a el/la Sr./Sra. <b>{$estudianteRepresentantePrincipal->getRepresentante()}</b>
            con número de cédula <b>{$estudianteRepresentantePrincipal->getRepresentante()->getIdentificacion()}</b>
            en calidad de representante autorizado para la recepción del mismo.
            Para constancia de lo actuado, las partes intervinientes firman el presente documento en señal de conformidad.
        </p>";

        $pdf->SetFont('helvetica', '', 15); // Fuente, estilo, tamaño
        $pdf->writeHTMLCell(0, 5, '', '', $contenido, 0, 1, 0, true, 'J', true);

        $fechaActual = new \DateTime();
        $fechaString = $fechaActual->format('Y-m-d');

        $pdf->SetFont('helvetica', 'B', 15); // Fuente, estilo, tamaño
        $pdf->Cell(0, 20, "Fecha de Impresión: {$fechaString}", 0, 1, 'R', 0, '', 0, false, 'T', 'M');

        // Espacio para la firma
        $pdf->Cell(0, 30, '', 0, 1, 'C');

        // Línea horizontal (ajusta las coordenadas según sea necesario)
        $pdf->Line(50, $pdf->GetY(), 160, $pdf->GetY());
        $pdf->Cell(0, 10, 'Rector', 0, 1, 'C');

        // Espacio entre firmas
        $pdf->Cell(0, 30, '', 0, 1, 'C');

        // Línea horizontal (ajusta las coordenadas según sea necesario)
        $pdf->Line(50, $pdf->GetY(), 160, $pdf->GetY());
        $pdf->Cell(0, 10, 'Representante', 0, 1, 'C');

        return $pdf;
    }

    public function printMatriculaList(
        string $periodoFilter,
        string $gradoFilter,
        string $paraleloFilter,
        string $estadoFilter,
        string $searchFilter,
        array $matriculas
    ) {

        $pdf = $this->pdfService->createPDF();

        //Título
        $titulo = "<p style='text-align: justify; margin: 0; padding: 0;'>
                        LiSTADO DE MATRICULAS
                   </p>";

        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->writeHTMLCell(0, 15, '', '', $titulo, 0, 1, 0, true, 'C', true);

        // Filtros
        $pdf->setFillColor(255, 255, 255); // Fondo blanco (RGB)
        $pdf->setTextColor(0); // Texto negro

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(35,5,'Periodo Lectivo: ',0,0,'L',1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0,5,$periodoFilter,0,1,'L');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(35,5,'Grado o Curso: ',0,0,'L',1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0,5,$gradoFilter,0,1,'L');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(35,5,'Paralelo: ',0,0,'L',1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0,5,$paraleloFilter,0,1,'L');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(35,5,'Estado: ',0,0,'L',1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0,5,$estadoFilter,0,1,'L');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(50,5,'Término de Busqueda: ',0,0,'L',1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0,5,$searchFilter,0,1,'L');

        //espacio
        $pdf->Ln(10);

        //cabecera de tabla
        $pdf->SetFont('helvetica', '', 8);
        $pdf->setFillColor(58, 83, 155);
        $pdf->setTextColor(255);
        $pdf->Cell(18, 10, 'Identificacion', 1, 0, 'L', true);
        $pdf->Cell(80, 10, 'Nombres', 1, 0, 'L', true);
        $pdf->Cell(22, 10, 'Periodo Lectivo', 1, 0, 'C', true);
        $pdf->Cell(0, 10, 'Grado', 1, 1, 'L', true);

        //Datos
        $pdf->setFillColor(255);
        $pdf->setTextColor(0);
        foreach ($matriculas as $matricula) {
            $pdf->Cell(18, 10, $matricula->getEstudiante()->getIdentificacion(), 1, 0, 'L', true);
            $pdf->Cell(80, 10, $matricula->getEstudiante(), 1, 0, 'L', true);
            $pdf->Cell(22, 10, $matricula->getPeriodoLectivo(), 1, 0, 'C', true);
            $pdf->Cell(0, 10, $matricula->getGradoEscolar(), 1, 1, 'L', true);
        }

        return $pdf;
    }
}

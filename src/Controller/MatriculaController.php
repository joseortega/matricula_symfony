<?php

namespace App\Controller;

use App\Entity\EstadoMatricula;
use App\Entity\Matricula;
use App\Repository\EstadoMatriculaRepository;
use App\Repository\EstudianteRepository;
use App\Repository\EstudianteRepresentanteRepository;
use App\Repository\GradoEscolarRepository;
use App\Repository\MatriculaRepository;
use App\Repository\ParaleloRepository;
use App\Repository\PeriodoLectivoRepository;
use App\Service\ReportPdfService;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\DeserializationContext;
use Knp\Component\Pager\PaginatorInterface;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Service\ReportExcelService;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Route('api')]
class MatriculaController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private PaginatorInterface $paginator,
        private EntityManagerInterface $entityManager,
        private MatriculaRepository $matriculaRepository,
        private ReportPdfService $reportPdfService,
        private EstudianteRepresentanteRepository $estudianteRepresentanteRepository,
        private PeriodoLectivoRepository $periodoLectivoRepository,
        private GradoEscolarRepository $gradoEscolarRepository,
        private ParaleloRepository $paraleloRepository,
        private EstadoMatriculaRepository $estadoMatriculaRepository,
        private ReportExcelService $reportExcelService,
    ){
    }
    
    #[Route('/matricula', name: 'app_matricula', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(Request $request): Response
    {
        $query = $this->getQuerySearch($request);
        
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('page_size', 10)/*limit per page*/
        );
               
        return new Response($this->serializer->serialize($pagination, 'json'));
    }

    #[Route('/matricula/{id}', name: 'app_matricula_show', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function show(int $id): Response
    {
        $matricula = $this->matriculaRepository->find($id);

        if(!$matricula){
            throw new BadRequestHttpException('No existe la matricula.');
        }

        return new Response($this->serializer->serialize($matricula, 'json'), Response::HTTP_OK);
    }
    
    #[Route('/matricula/create', name: 'app_matricula_create', methods: ['POST'], defaults: ["_format"=>"json"])]
    public function create(Request $request): Response
    {           
        $matricula = $this->serializer->deserialize($request->getContent(), Matricula::class, 'json');

        $matricula->setFechaInscripcion(new \DateTimeImmutable());

        if($matricula->isLegalizada()){
            $matricula->setFechaLegalizacion(new \DateTimeImmutable());
        }

        $errors = $this->validator->validate($matricula);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            throw new BadRequestHttpException(implode(' ', $errorMessages));
        }
        
        //Comprobar si el periodo lectivo está activado para matricula
        if(!$matricula->getPeriodoLectivo()->isHabilitadoParaMatricula()){
            throw new BadRequestHttpException('El periodo lectivo que seleccionó no está habilitado para matrícula.');
        }
        
        $this->entityManager->persist($matricula);
        $this->entityManager->flush(); 
        
        return new Response($this->serializer->serialize($matricula, 'json'), Response::HTTP_OK); 
    }

    #[Route('/matricula/update/{id}', name: 'app_matricula_update', methods: ['PUT'], defaults: ["_format"=>"json"])]
    public function update(int $id, Request $request): Response
    {           
        $matricula = $this->matriculaRepository->find($id);

        $isLegalizada = $matricula->isLegalizada();
        
        $context = new DeserializationContext();
        
        $context->setAttribute('target', $matricula);
        $updatedMatricula = $this->serializer->deserialize($request->getContent(), Matricula::class, 'json', $context);

        if($isLegalizada !== $updatedMatricula->isLegalizada()){
            if($updatedMatricula->isLegalizada()){
                $updatedMatricula->setFechaLegalizacion(new \DateTimeImmutable());
            }else{
                $updatedMatricula->setFechaLegalizacion(null);
            }
        }

        $errors = $this->validator->validate($updatedMatricula);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            throw new BadRequestHttpException(implode(' ', $errorMessages));
        }

        $this->entityManager->persist($updatedMatricula);
        $this->entityManager->flush(); 
        
        return new Response($this->serializer->serialize($updatedMatricula, 'json'), Response::HTTP_OK); 
    }

    #[Route('/matricula/pdf-certificado-matricula/{id}', name: 'app_matricula_pdf_certificado_matricula', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function pdfCetificadoMatricula(int $id): Response
    {
        $matricula = $this->matriculaRepository->find($id);

        if(!$matricula){
            throw new BadRequestHttpException('No existe la matricula.');
        }

        // Generar el PDF
        $pdf = $this->reportPdfService->printCertifidadoMatricula($matricula);
        // 'S' devuelve el PDF como cadena
        $pdfContent = $pdf->Output('', 'S');
        // Devolver el PDF como respuesta
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="certificado-matricula.pdf"'
        ]);
    }

    #[Route('/matricula/pdf-certificado-preinscripcion/{id}', name: 'app_matricula_pdf_certificado_preinscripcion', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function pdfCetificadoPreinscripcion(int $id): Response
    {
        $matricula = $this->matriculaRepository->find($id);

        if(!$matricula){
            throw new BadRequestHttpException('No existe la matricula.');
        }

        // Generar el PDF
        $pdf = $this->reportPdfService->printCertifidadoPreInscripcion($matricula);
        // 'S' devuelve el PDF como cadena
        $pdfContent = $pdf->Output('', 'S');
        // Devolver el PDF como respuesta
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="certificado-preinscripcion.pdf"'
        ]);
    }

    #[Route('/matricula/pdf-certificado-matricula-asistencia/{id}', name: 'app_matricula_pdf_certificado_matricula_asistencia', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function pdfCetificadoMatriculaAsistencia(int $id): Response
    {
        $matricula = $this->matriculaRepository->find($id);

        if(!$matricula){
            throw new BadRequestHttpException('No existe la matricula.');
        }

        // Generar el PDF
        $pdf = $this->reportPdfService->printCertifidadoMatriculaAsistencia($matricula);
        // 'S' devuelve el PDF como cadena
        $pdfContent = $pdf->Output('', 'S');
        // Devolver el PDF como respuesta
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"'
        ]);
    }
    
    #[Route('/matricula/pdf-carta-autorizacion/{id}', name: 'app_matricula_pdf_carta_autorizacion', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function pdfCartaAutorizacion(int $id): Response
    {
        $matricula = $this->matriculaRepository->find($id);
        if(!$matricula){
            throw new BadRequestHttpException('No existe la matricula.');
        }

        $estudianteRepresentantePrincipal = $this->estudianteRepresentanteRepository->findByEstudiantePrincipalOne($matricula->getEstudiante()->getId());
        if(!$estudianteRepresentantePrincipal){
            throw new BadRequestHttpException('No existe el representante principal.');
        }

        if(!$matricula->isLegalizada()){
            throw new BadRequestHttpException('Para imprimir los documentos y legalizar, en datos de matricula marque como legalizada');
        }

        // Generar el PDF
        $pdf = $this->reportPdfService->printCartaAutorizacion($matricula, $estudianteRepresentantePrincipal);
        // 'S' devuelve el PDF como cadena
        $pdfContent = $pdf->Output('', 'S');
        // Devolver el PDF como respuesta
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"'
        ]);
    }
    
    #[Route('/matricula/pdf-acta-compromiso/{id}', name: 'app_matricula_pdf_acta_compromiso', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function pdfActaCompromiso(int $id): Response
    {
        $matricula = $this->matriculaRepository->find($id);
        if(!$matricula){
            throw new BadRequestHttpException('No existe la matricula.');
        }

        $estudianteRepresentantePrincipal = $this->estudianteRepresentanteRepository->findByEstudiantePrincipalOne($matricula->getEstudiante()->getId());
        if(!$estudianteRepresentantePrincipal){
            throw new BadRequestHttpException('No existe el representante principal.');
        }

        if(!$matricula->isLegalizada()){
            throw new BadRequestHttpException('Para imprimir los documentos y legalizar, en datos de matricula marque como legalizada');
        }

        // Generar el PDF
        $pdf = $this->reportPdfService->printActaCompromiso($matricula, $estudianteRepresentantePrincipal);
        // 'S' devuelve el PDF como cadena
        $pdfContent = $pdf->Output('', 'S');
        // Devolver el PDF como respuesta
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"'
        ]);
    }

    #[Route('/pdf-matricula-list', name: 'app_matricula_pdf_matricula_list', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function pdfFilterList(Request $request): Response
    {
        $periodoLectivoId = $request->query->get('periodo_lectivo');
        $gradoEscolarId = $request->query->get('grado_escolar');
        $paraleloId = $request->query->get('paralelo');
        $estadoMatriculas = $request->query->get('estado_matriculas');
        $searchTerm = $request->query->get('search_term');

        $periodoFilter = "Todos";
        if($periodoLectivoId){
            $periodoLectivo = $this->periodoLectivoRepository->find($periodoLectivoId);
            $periodoFilter = $periodoLectivo ? $periodoLectivo->getDescripcion() : "No Encontrado";
        }

        $gradoEscolarFilter = "Todos";
        if($gradoEscolarId){
            $gradoEscolar = $this->gradoEscolarRepository->find($gradoEscolarId);
            $gradoEscolarFilter = $gradoEscolar ? $gradoEscolar->getDescripcion(): "No Encontrado";
        }

        $paraleloFilter = "Todos";
        if($paraleloId){
            $paralelo = $this->paraleloRepository->find($paraleloId);
            $paraleloFilter = $paralelo ? $paralelo->getDescripcion(): "No Encontrado";
        }

        $estadoMatriculasIds = [];

        if($estadoMatriculas){
            $estadoMatriculasIds = explode(',', $estadoMatriculas);
            // 👉 convierte "1,3,4" en ["1","3","4"]
            $estadoMatriculasIds = array_map('intval', $estadoMatriculasIds);
            // 👉 convierte a enteros [1,3,4]
        }

        $estadoMatriculaFilter = [];
        if (!empty($estadoMatriculasIds)) { // ahora es un array
            foreach ($estadoMatriculasIds as $id) {
                $estado = $this->estadoMatriculaRepository->find($id);
                if ($estado) {
                    $estadoMatriculaFilter[] = $estado->getDescripcion();
                } else {
                    $estadoMatriculaFilter[] = "No Encontrado";
                }
            }
        }

        $searchFilter = $searchTerm ?: "Ninguno";


        $query = $this->matriculaRepository->findAllQuery(
            $periodoLectivoId,
            $gradoEscolarId,
            $paraleloId,
            $estadoMatriculasIds,
            $searchTerm
        );

        // Generar el PDF
        $pdf = $this->reportPdfService->printMatriculaList(
            $periodoFilter,
            $gradoEscolarFilter,
            $paraleloFilter,
            $estadoMatriculaFilter,
            $searchFilter,
            $query->getResult()
        );
        // 'S' devuelve el PDF como cadena
        $pdfContent = $pdf->Output('', 'S');
        // Devolver el PDF como respuesta
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"'
        ]);
    }

    private function getQuerySearch(Request $request): Query
    {
        $periodoLectivoId = $request->query->get('periodo_lectivo');
        $gradoEscolarId = $request->query->get('grado_escolar');
        $paraleloId = $request->query->get('paralelo');
        $estadoMatriculas = $request->query->get('estado_matriculas');
        $searchTerm = $request->query->get('search_term');

        $estadoMatriculasIds = [];

        if($estadoMatriculas){
            $estadoMatriculasIds = explode(',', $estadoMatriculas);
            // 👉 convierte "1,3,4" en ["1","3","4"]
            $estadoMatriculasIds = array_map('intval', $estadoMatriculasIds);
            // 👉 convierte a enteros [1,3,4]
        }

        $query = $this->matriculaRepository->findAllQuery(
            $periodoLectivoId,
            $gradoEscolarId,
            $paraleloId,
            $estadoMatriculasIds,
            $searchTerm
        );

        return $query;
    }

    #[Route('/excel-matricula-list', name: 'app_matricula_excel_matricula_list', methods: ['GET'])]
    public function excelFilterList(Request $request): Response
    {
        $periodoLectivoId = $request->query->get('periodo_lectivo');
        $gradoEscolarId = $request->query->get('grado_escolar');
        $paraleloId = $request->query->get('paralelo');
        $estadoMatriculas = $request->query->get('estado_matriculas');
        $searchTerm = $request->query->get('search_term');

        $periodoFilter = "Todos";
        if($periodoLectivoId){
            $periodoLectivo = $this->periodoLectivoRepository->find($periodoLectivoId);
            $periodoFilter = $periodoLectivo ? $periodoLectivo->getDescripcion() : "No Encontrado";
        }

        $gradoEscolarFilter = "Todos";
        if($gradoEscolarId){
            $gradoEscolar = $this->gradoEscolarRepository->find($gradoEscolarId);
            $gradoEscolarFilter = $gradoEscolar ? $gradoEscolar->getDescripcion(): "No Encontrado";
        }

        $paraleloFilter = "Todos";
        if($paraleloId){
            $paralelo = $this->paraleloRepository->find($paraleloId);
            $paraleloFilter = $paralelo ? $paralelo->getDescripcion(): "No Encontrado";
        }

        $estadoMatriculasIds = [];

        if($estadoMatriculas){
            $estadoMatriculasIds = explode(',', $estadoMatriculas);
            // 👉 convierte "1,3,4" en ["1","3","4"]
            $estadoMatriculasIds = array_map('intval', $estadoMatriculasIds);
            // 👉 convierte a enteros [1,3,4]
        }

        $estadoMatriculaFilter = [];
        if (!empty($estadoMatriculasIds)) { // ahora es un array
            foreach ($estadoMatriculasIds as $id) {
                $estado = $this->estadoMatriculaRepository->find($id);
                if ($estado) {
                    $estadoMatriculaFilter[] = $estado->getDescripcion();
                } else {
                    $estadoMatriculaFilter[] = "No Encontrado";
                }
            }
        }

        $searchFilter = $searchTerm ?: "Ninguno";


        $query = $this->matriculaRepository->findAllQuery(
            $periodoLectivoId,
            $gradoEscolarId,
            $paraleloId,
            $estadoMatriculasIds,
            $searchTerm
        );

        $spreadsheet = $this->reportExcelService->printMatriculaList($periodoFilter,
                                                                    $gradoEscolarFilter,
                                                                    $paraleloFilter,
                                                                    $estadoMatriculaFilter,
                                                                    $searchFilter,
                                                                    $query->getResult());
        $writer = new Xlsx($spreadsheet);

        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set(
            'Content-Type',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        $response->headers->set(
            'Content-Disposition',
            'attachment;filename="reporte_matriculas.xlsx"'
        );

        $response->headers->set('Cache-Control', 'max-age=0');

        $response->setPrivate();

        return $response;
    }
}

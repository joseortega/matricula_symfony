<?php

namespace App\Controller;

use App\Entity\Matricula;
use App\Repository\EstudianteRepresentanteRepository;
use App\Repository\GradoEscolarRepository;
use App\Repository\MatriculaRepository;
use App\Repository\ParaleloRepository;
use App\Repository\PeriodoLectivoRepository;
use App\Service\ReportService;

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

#[Route('api')]
class MatriculaController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private PaginatorInterface $paginator,
        private EntityManagerInterface $entityManager,
        private MatriculaRepository $matriculaRepository,
        private ReportService $reportService,
        private EstudianteRepresentanteRepository $estudianteRepresentanteRepository,
        private PeriodoLectivoRepository $periodoLectivoRepository,
        private GradoEscolarRepository $gradoEscolarRepository,
        private ParaleloRepository $paraleloRepository,
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
        
        $context = new DeserializationContext();
        
        $context->setAttribute('target', $matricula);
        $updatedMatricula = $this->serializer->deserialize($request->getContent(), Matricula::class, 'json', $context);

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
        $pdf = $this->reportService->printCertifidadoMatricula($matricula);
        // 'S' devuelve el PDF como cadena
        $pdfContent = $pdf->Output('', 'S');
        // Devolver el PDF como respuesta
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"'
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
        $pdf = $this->reportService->printCertifidadoMatriculaAsistencia($matricula);
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

        // Generar el PDF
        $pdf = $this->reportService->printCartaAutorizacion($matricula, $estudianteRepresentantePrincipal);
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

        // Generar el PDF
        $pdf = $this->reportService->printActaCompromiso($matricula, $estudianteRepresentantePrincipal);
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
        $estado = $request->query->get('estado');
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
            $paraleloFilter = $paraleloId ? $paralelo->getDescripcion(): "No Encontrado";
        }

        $estadoFilter = $estado ?: "Todos";

        $searchFilter = $searchTerm ?: "Ninguno";


        $query = $this->matriculaRepository->findAllQuery(
            $periodoLectivoId,
            $gradoEscolarId,
            $paraleloId,
            $estado,
            $searchTerm
        );

        // Generar el PDF
        $pdf = $this->reportService->printMatriculaList(
            $periodoFilter,
            $gradoEscolarFilter,
            $paraleloFilter,
            $estadoFilter,
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
        $estado = $request->query->get('estado');
        $searchTerm = $request->query->get('search_term');

        $query = $this->matriculaRepository->findAllQuery(
            $periodoLectivoId,
            $gradoEscolarId,
            $paraleloId,
            $estado,
            $searchTerm
        );

        return $query;
    }
}

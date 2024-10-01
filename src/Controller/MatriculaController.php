<?php

namespace App\Controller;

use App\Entity\Matricula;
use App\Repository\MatriculaRepository;
use App\Service\PDFService;
use App\Service\ReportService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;

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
        private PDFService $pdfService,
        private ReportService $reportService,
    ){
    }
    
    #[Route('/matricula', name: 'app_matricula', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(Request $request): Response
    {
        $periodoLectivoId = $request->query->get('periodo_lectivo');
        $gradoEscolarId = $request->query->get('grado_escolar');
        $searchTerm = $request->query->get('search_term');
        
         $query = $this->matriculaRepository->findAllQuery4($gradoEscolarId, $periodoLectivoId, $searchTerm);
        
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
            throw new NotFoundHttpException('No existe la matricula');
        }

        return new Response($this->serializer->serialize($matricula, 'json'), Response::HTTP_OK);
    }
    
    #[Route('/matricula/create', name: 'app_matricula_create', methods: ['POST'], defaults: ["_format"=>"json"])]
    public function create(Request $request): Response
    {           
        $matricula = $this->serializer->deserialize($request->getContent(), Matricula::class, 'json');
        dump($matricula);
        
        $matricula->setFecha(new \DateTime());

        $errors = $this->validator->validate($matricula);
        
        if(count($errors) > 0){
            throw new InvalidArgumentException('hola soy jose error');
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
        
        if(count($errors) > 0){
            throw new InvalidArgumentException((string) $errors);
        }
        $this->entityManager->persist($updatedMatricula);
        $this->entityManager->flush(); 
        
        return new Response($this->serializer->serialize($updatedMatricula, 'json'), Response::HTTP_OK); 
    }

    #[Route('/matricula/pdf-certificado-matricula/{id}', name: 'app_matricula_pdf_certificado_matricula', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function pdfCetificadoMatricula(int $id): Response
    {
        $matricula = $this->matriculaRepository->find($id);
        // Generar el PDF
        $pdf = $this->reportService->printCertifidadoMatricula($matricula);
      
        
        $pdfContent = $pdf->Output('', 'S'); // 'S' devuelve el PDF como cadena
        

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
        // Generar el PDF
        $pdf = $this->reportService->printCartaAutorizacion($matricula);
      
        
        $pdfContent = $pdf->Output('', 'S'); // 'S' devuelve el PDF como cadena
        

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
        // Generar el PDF
        $pdf = $this->reportService->printActaCompromiso($matricula);
      
        
        $pdfContent = $pdf->Output('', 'S'); // 'S' devuelve el PDF como cadena
        

        // Devolver el PDF como respuesta
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"'
        ]);
    }
}

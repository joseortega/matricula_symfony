<?php

namespace App\Controller;

use App\Entity\Expediente;
use App\Repository\EstudianteRepository;
use App\Repository\EstudianteRepresentanteRepository;
use App\Repository\ExpedienteRepository;
use App\Service\ReportService;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api')]
class ExpedienteController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
        private EstudianteRepository $estudianteRepository,
        private ExpedienteRepository $expedienteRepository,
        private ReportService $reportService,
        private EstudianteRepresentanteRepository $estudianteRepresentanteRepository,
    ){
    }
    
    #[Route('/expediente', name: 'app_expediente', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(Request $request): Response
    {

        $query = $this->expedienteRepository->findAllQuery($request->query->get('filter'));
        
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return new Response($this->serializer->serialize($pagination, 'json'));
    }

    #[Route('/estudiante/{estudianteId}/expediente/', methods: ['GET'],  name: 'app_expediente_show')]
    public function show(int $estudianteId): Response
    {
        $expediente = $this->expedienteRepository->findOneBy(['estudiante'=>$estudianteId]);

        if (!$expediente) {
            throw new BadRequestHttpException('El expediente aún no se encuentra registrado, registre');
        }

        return new Response($this->serializer->serialize($expediente, 'json'), Response::HTTP_OK);
    }

    #[Route('/estudiante/{estudianteId}/expediente/verifica', methods: ['GET'],  name: 'app_expediente_verifica')]
    public function verficaExpediente(int $estudianteId): Response
    {
        $existeExpediente = false;

        $expediente = $this->expedienteRepository->findOneBy(['estudiante'=>$estudianteId]);

        if ($expediente) {
           $existeExpediente = true;
        }

        return new Response($this->serializer->serialize($existeExpediente, 'json'), Response::HTTP_OK);
    }

    #[Route('/estudiante/{estudianteId}/expediente/create', methods: ['POST'], name: 'app_expediente_create')]
    public function create(int $estudianteId, Request $request): Response
    {
        $expediente = $this->serializer->deserialize($request->getContent(), Expediente::class, 'json');
        $expediente->setEstudiante($this->estudianteRepository->find($estudianteId));
        $expediente->setFechaIngreso(new \DateTime());

        $errors = $this->validator->validate($expediente);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            throw new BadRequestHttpException(implode(' ', $errorMessages));
        }

        $this->entityManager->persist($expediente);
        $this->entityManager->flush();

        return new Response($this->serializer->serialize($expediente, 'json'), Response::HTTP_CREATED);
    }

    #[Route('/estudiante/{estudianteId}/expediente/update', methods: ['PUT'], name: 'app_expediente_update')]
    public function update(int $estudianteId, Request $request): Response
    {
        $expediente = $this->expedienteRepository->findOneBy(['estudiante' => $estudianteId]);

        //deserializacion de datos
        $context = new DeserializationContext();
        $context->setAttribute('tarjet', $expediente);

        $updateExpediente = $this->serializer->deserialize($request->getContent(), Expediente::class, 'json', $context);

        $errors = $this->validator->validate($updateExpediente);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            throw new BadRequestHttpException(implode(' ', $errorMessages));
        }

         $this->entityManager->persist($updateExpediente);
        $this->entityManager->flush();

        return new Response($this->serializer->serialize($updateExpediente, 'json'), Response::HTTP_OK);
    }

    #[Route('/expediente/withdraw/{id}', methods: ['GET'], name: 'app_expediente_withdraw')]
    public function withdraw(int $id, Request $request): Response
    {
        $expediente = $this->expedienteRepository->find($id);

        if (!$expediente) {
            throw new BadRequestHttpException('EL estudiante aún no tiene el expediente');
        }

        $expediente->setFechaRetiro(new \DateTime());
        $expediente->setEstaRetirado(true);
        $this->entityManager->persist($expediente);
        $this->entityManager->flush();

        return new Response($this->serializer->serialize($expediente, 'json'), Response::HTTP_OK);
    }

    #[Route('/expediente/reentry/{id}', methods: ['GET'], name: 'app_expediente_reentry')]
    public function reentry(int $id, Request $request): Response
    {
        $expediente = $this->expedienteRepository->find($id);

        if (!$expediente) {
            throw new BadRequestHttpException('EL estudiante aún no tiene el expediente');
        }

        $expediente->setFechaRetiro(null);
        $expediente->setEstaRetirado(false);
        $this->entityManager->persist($expediente);
        $this->entityManager->flush();

        return new Response($this->serializer->serialize($expediente, 'json'), Response::HTTP_OK);
    }

    #[Route('/expediente/withdraw-print/{id}', methods: ['GET'], name: 'app_expediente_withdraw-print')]
    public function pdfWithdrawPrint(int $id): Response
    {
        $expediente = $this->expedienteRepository->find($id);
        if (!$expediente) {
            throw new BadRequestHttpException('El expediente no existe');
        }

        $estudianteRepresentantePrincipal = $this->estudianteRepresentanteRepository->findByEstudiantePrincipalOne($expediente->getEstudiante()->getId());
        if (!$estudianteRepresentantePrincipal) {
            throw new BadRequestHttpException('El representante principal no existe');
        }

        // Generar el PDF
        $pdf = $this->reportService->printRetiroExpediente($expediente, $estudianteRepresentantePrincipal);
        // 'S' devuelve el PDF como cadena
        $pdfContent = $pdf->Output('', 'S');
        // Devolver el PDF como respuesta
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"'
        ]);
    }
}

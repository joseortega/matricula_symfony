<?php

namespace App\Controller;

use App\Entity\Expediente;
use App\Repository\EstudianteRepository;
use App\Repository\ExpedienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    ){
    }

    #[Route('/estudiante/{estudianteId}/expediente/', methods: ['GET'],  name: 'app_expediente_show')]
    public function show(int $estudianteId): Response
    {
        $expediente = $this->expedienteRepository->findOneBy(['estudiante'=>$estudianteId]);

        if (!$expediente) {
            throw new NotFoundHttpException('Expediente not found.');
        }

        return new Response($this->serializer->serialize($expediente, 'json'), Response::HTTP_OK);
    }

    #[Route('/estudiante/{estudianteId}/expediente/create', methods: ['POST'], name: 'app_expediente_create')]
    public function create(int $estudianteId, Request $request): Response
    {
        $expediente = $this->serializer->deserialize($request->getContent(), Expediente::class, 'json');
        $expediente->setEstudiante($this->estudianteRepository->find($estudianteId));

        $errors = $this->validator->validate($expediente);

        if (count($errors) > 0) {
            throw new InvalidArgumentException((string) $errors);
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
            throw new InvalidArgumentException((string) $errors);
        }

         $this->entityManager->persist($updateExpediente);
        $this->entityManager->flush();

        return new Response($this->serializer->serialize($updateExpediente, 'json'), Response::HTTP_OK);
    }
}

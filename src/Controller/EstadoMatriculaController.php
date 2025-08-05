<?php

namespace App\Controller;

use App\Repository\EstadoMatriculaRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api')]
final class EstadoMatriculaController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private EstadoMatriculaRepository $estadoMatriculaRepository,
    ){
    }
    #[Route('/estado-matricula', name: 'app_estado-matricula', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $estados = $this->estadoMatriculaRepository->findAll();

        return new Response($this->serializer->serialize($estados, 'json'));
    }
}

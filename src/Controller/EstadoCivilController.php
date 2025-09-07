<?php

namespace App\Controller;

use App\Repository\EstadoCivilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;


#[Route('api')]
class EstadoCivilController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private EstadoCivilRepository $estadoCivilRepository,
    ){
    }

    #[Route('/estado-civil', name: 'app_estado_civil', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $estadoCiviles = $this->estadoCivilRepository->findAll();
        
         return new Response($this->serializer->serialize($estadoCiviles, 'json'));
    }
}

<?php

namespace App\Controller;

use App\Repository\JornadaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;
//use Symfony\Component\Serializer\SerializerInterface;

#[Route('api')]
class JornadaController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private JornadaRepository $jornadaRepository,
    ){
    }

    #[Route('/jornada', name: 'app_jornada', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $jornadas = $this->jornadaRepository->findAll();
        
         return new Response($this->serializer->serialize($jornadas, 'json'));
    }
}

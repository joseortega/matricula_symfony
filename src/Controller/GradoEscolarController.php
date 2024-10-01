<?php

namespace App\Controller;

use App\Repository\GradoEscolarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;


#[Route('api')]
class GradoEscolarController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private GradoEscolarRepository $gradoEscolarRepository,
    ){
    }

    #[Route('/grado-escolar', name: 'app_grado-escolar', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $gradoEscolares = $this->gradoEscolarRepository->findAll();
        
         return new Response($this->serializer->serialize($gradoEscolares, 'json'));
    }
}

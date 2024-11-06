<?php

namespace App\Controller;

use App\Repository\RequisitoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;


#[Route('api')]
class RequisitoController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private RequisitoRepository $requisitoRepository,
    ){
    }

    #[Route('/requisito', name: 'app_requisito', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $requisitos = $this->requisitoRepository->findAll();
        
         return new Response($this->serializer->serialize($requisitos, 'json'));
    }
}

<?php

namespace App\Controller;

use App\Repository\ParaleloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;

#[Route('api')]
class ParaleloController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ParaleloRepository $paraleloRepository,
    ){
    }

    #[Route('/paralelo', name: 'app_paralelo', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $paralelos = $this->paraleloRepository->findAll();
        
         return new Response($this->serializer->serialize($paralelos, 'json'));
    }
}

<?php

namespace App\Controller;

use App\Repository\UniformeTallaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;


#[Route('api')]
class UniformeTallaController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private UniformeTallaRepository $uniformeTallaRepository,
    ){
    }

    #[Route('/uniforme-talla', name: 'app_uniforme_talla', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $uniformeTallas = $this->uniformeTallaRepository->findAll();
        
         return new Response($this->serializer->serialize($uniformeTallas, 'json'));
    }
}

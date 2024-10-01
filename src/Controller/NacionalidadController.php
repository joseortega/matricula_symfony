<?php

namespace App\Controller;

use App\Repository\NacionalidadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;


#[Route('api')]
class NacionalidadController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private NacionalidadRepository $nacionalidadRepository,
    ){
    }

    #[Route('/nacionalidad', name: 'app_nacionalidad', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $nacionalidades = $this->nacionalidadRepository->findAll();
        
         return new Response($this->serializer->serialize($nacionalidades, 'json'));
    }
}

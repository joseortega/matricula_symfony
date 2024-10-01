<?php

namespace App\Controller;

use App\Repository\ModalidadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;

#[Route('api')]
class ModalidadController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ModalidadRepository $modalidadRepository,
    ){
    }

    #[Route('/modalidad', name: 'app_modalidad', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $modalidades = $this->modalidadRepository->findAll();
        
         return new Response($this->serializer->serialize($modalidades, 'json'));
    }
}

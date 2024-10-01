<?php

namespace App\Controller;

use App\Repository\PeriodoLectivoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;

#[Route('api')]
class PeriodoLectivoController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private PeriodoLectivoRepository $periodoLectivoRepository,
    ){
    }

    #[Route('/periodo-lectivo', name: 'app_periodo-lectivo', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $periodoLectivos = $this->periodoLectivoRepository->findAll();
        
         return new Response($this->serializer->serialize($periodoLectivos, 'json'));
    }
}

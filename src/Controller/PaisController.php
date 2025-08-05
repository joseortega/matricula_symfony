<?php

namespace App\Controller;

use App\Repository\PaisRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('api')]
Class PaisController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private PaisRepository $paisRepository,
    ){
    }
    #[Route('/pais', name: 'app_pais', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $paralelos = $this->paisRepository->findAll();

        return new Response($this->serializer->serialize($paralelos, 'json'));
    }

    #[Route('/pais/search', name: 'app_pais_search', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function search(Request $request): Response
    {
        $paises = $this->paisRepository->search($request->query->get('filter'));

        return new Response($this->serializer->serialize($paises, 'json'), Response::HTTP_OK);
    }
}

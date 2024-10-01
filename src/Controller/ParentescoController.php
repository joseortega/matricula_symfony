<?php

namespace App\Controller;

use App\Repository\ParentescoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;

#[Route('api')]
class ParentescoController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ParentescoRepository $parentescoRepository,
    ){
    }

    #[Route('/parentesco', name: 'app_parentesco', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(): Response
    {
        $parentescos = $this->parentescoRepository->findAll();
        
         return new Response($this->serializer->serialize($parentescos, 'json'));
    }
}

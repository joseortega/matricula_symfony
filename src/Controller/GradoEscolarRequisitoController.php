<?php

namespace App\Controller;

use App\Repository\GradoEscolarRepository;
use App\Repository\GradoEscolarRequisitoRepository;
use App\Repository\RequisitoRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api')]
class GradoEscolarRequisitoController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
        private RequisitoRepository $requisitoRepository,
        private GradoEscolarRequisitoRepository $gradoEscolarRequisitoRepository
    ){}

    #[Route('/grado-escolar/{gradoEscolarId}/requisito', name: 'app_grado-escolar_requisito', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(int $gradoEscolarId): Response
    {
        $gradoEscolarRequisitos = $this->gradoEscolarRequisitoRepository->findBy(['gradoEscolar'=>$gradoEscolarId]);

        return new Response($this->serializer->serialize($gradoEscolarRequisitos, 'json'));
    }
}

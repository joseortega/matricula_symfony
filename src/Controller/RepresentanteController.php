<?php

namespace App\Controller;

use App\Entity\Representante;
use App\Repository\RepresentanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\DeserializationContext;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('api')]
class RepresentanteController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private PaginatorInterface $paginator,
        private EntityManagerInterface $entityManager,
        private RepresentanteRepository $representanteRepository,
    ){
    }

    #[Route('/representante', name: 'app_representante_index', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(Request $request): Response
    {
        $query = $this->representanteRepository->findAllQuery($request->query->get('filter'));
        
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
         return new Response($this->serializer->serialize($pagination, 'json'));
    }

    #[Route('/representante/search', name: 'app_representante_search', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function search(Request $request): Response
    {
        $representantes = $this->representanteRepository->search($request->query->get('filter'));

        return new Response($this->serializer->serialize($representantes, 'json'), Response::HTTP_OK);
    }

    #[Route('/representante/{id}', name: 'app_representante_show', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function show(int $id): Response
    {
        $representante = $this->representanteRepository->find($id);

        if (!$representante) {
            throw new BadRequestHttpException('No existe el o la representante.');
        }

        return new Response($this->serializer->serialize($representante, 'json'));
    }
    
    #[Route('/representante/create', name: 'app_representante_create', methods: ['POST'], defaults: ["_format"=>"json"])]
    public function create(Request $request): Response
    {           
        $representante = $this->serializer->deserialize($request->getContent(), Representante::class, 'json');

        $errors = $this->validator->validate($representante);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            throw new BadRequestHttpException(implode(' ', $errorMessages));
        }

        $this->entityManager->persist($representante);
        $this->entityManager->flush();
        
        return new Response($this->serializer->serialize($representante, 'json'), Response::HTTP_OK);
    }
    
    #[Route('/representante/update/{id}', name: 'app_representante_update', methods: ['PUT'], defaults: ["_format"=>"json"])]
    public function update(int $id, Request $request): Response
    {             
        $representante = $this->representanteRepository->find($id);
        
        $context = new DeserializationContext();
        
        $context->setAttribute('target', $representante);
        $updatedRepresentante = $this->serializer->deserialize($request->getContent(), Representante::class, 'json', $context);
        
         $errors = $this->validator->validate($updatedRepresentante);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            throw new BadRequestHttpException(implode(' ', $errorMessages));
        }
        
        $this->entityManager->persist($updatedRepresentante);
        $this->entityManager->flush();
        
        return new Response($this->serializer->serialize($updatedRepresentante, 'json'), Response::HTTP_OK);
    }

}

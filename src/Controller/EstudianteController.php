<?php

namespace App\Controller;

use App\Entity\Estudiante;
use App\Repository\EstudianteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\DeserializationContext;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('api')]
class EstudianteController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private PaginatorInterface $paginator,
        private EntityManagerInterface $entityManager,
        private EstudianteRepository $estudianteRepository,
    ){
    }

    #[Route('/estudiante', name: 'app_estudiante', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function index(Request $request): Response
    {
        $query = $this->estudianteRepository->findAllQuery($request->query->get('filter'));
        
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return new Response($this->serializer->serialize($pagination, 'json'));
    }


    #[Route('/estudiante/create', name: 'app_estudiante_create', methods: ['POST'], defaults: ["_format"=>"json"])]
    public function create(Request $request): Response
    {                   
        $estudiante = $this->serializer->deserialize($request->getContent(), Estudiante::class, 'json');
        
        $errors = $this->validator->validate($estudiante);
        
        if (count($errors) > 0) {
            throw new InvalidArgumentException((string) $errors);
        }
        
        $this->entityManager->persist($estudiante);
        $this->entityManager->flush();
        
        return new Response($this->serializer->serialize($estudiante, 'json'), Response::HTTP_OK);
    }
    
    #[Route('/estudiante/update/{id}', name: 'app_estudiante_update', methods: ['PUT'], defaults: ["_format"=>"json"])]
    public function update(int $id, Request $request): Response
    {   
        $estudiante = $this->estudianteRepository->find($id);
        
        $context = new DeserializationContext();
        
        $context->setAttribute('target', $estudiante);
        $updatedEstudiante = $this->serializer->deserialize($request->getContent(), Estudiante::class, 'json', $context);
        
        $errors = $this->validator->validate($updatedEstudiante);
       
        if (count($errors) > 0) {
            throw new InvalidArgumentException((string) $errors);
        }
        
        $this->entityManager->persist($updatedEstudiante);
        $this->entityManager->flush();
        
        return new Response($this->serializer->serialize($updatedEstudiante, 'json'), Response::HTTP_OK);
    }

    #[Route('/estudiante/search', name: 'app_estudiante_search', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function search(Request $request): Response
    {
        $estudiantes = $this->estudianteRepository->search($request->query->get('filter'));

        return new Response($this->serializer->serialize($estudiantes, 'json'), Response::HTTP_OK);
    }
    #[Route('/estudiante/{id}', name: 'app_estudiante_detail', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function detail(int $id): Response
    {
        $estudiante = $this->estudianteRepository->find($id);

        if(!$estudiante){
            throw new NotFoundHttpException('Estudiante no existe');
        }
        return new Response($this->serializer->serialize($estudiante, 'json'), Response::HTTP_OK);
    }


    
//    public function update(int $id, Request $request, ValidatorInterface $validator, SerializerInterface $serializer, EntityManagerInterface $entityManager, NacionalidadRepository $nacionalidadRepository, EstudianteRepository $estudianteRespository, RepresentanteRepository $representanteRepository): Response
//    {   
//        $estudiante = $estudianteRespository->find($id);
//        
//        $data = json_decode($request->getContent());
//        
//        $estudiante->setIdentificacion($data->identificacion);
//        $estudiante->setApellidos($data->apellidos);
//        $estudiante->setNombres($data->nombres);
//        $estudiante->setSexo($data->sexo);
//        $estudiante->setFechaNacimiento(new \DateTime($data->fecha_nacimiento));
//        $estudiante->setNacionalidad($nacionalidadRepository->find($data->nacionalidad->id));
//        $estudiante->setLugarResidencia($data->lugar_residencia);
//        
//        if(isset($data->telefono)){
//            $estudiante->setTelefono($data->telefono);
//        }
//        if(isset($data->correo)){
//            $estudiante->setCorreo($data->correo);
//        }
//        if(isset($data->representante->id)){
//            $estudiante->setRepresentante($representanteRepository->find($data->representante->id));
//        }
//        
//        $errors = $validator->validate($estudiante);
//       
//        if (count($errors) > 0) {
//            throw new InvalidArgumentException((string) $errors);
//        }
//        
//        $entityManager->persist($estudiante);
//        $entityManager->flush();
//        
//        return new Response($serializer->serialize($estudiante, 'json'), Response::HTTP_OK); 
//    }
}

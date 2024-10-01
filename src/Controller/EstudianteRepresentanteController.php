<?php

namespace App\Controller;

use App\Repository\EstudianteRepresentanteRepository;
use App\Repository\EstudianteRepository;
use App\Entity\EstudianteRepresentante;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\DeserializationContext;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('api')]
class EstudianteRepresentanteController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
        private EstudianteRepository $estudianteRepository,
        private EstudianteRepresentanteRepository $estudianteRepresentanteRepository,
    ){
    }

    #[Route('/estudiante/{estudianteId}/representante', name: 'app_estudiante_representante')]
    public function index(int $estudianteId): Response
    {
        $estudianteRepresentantes = $this->estudianteRepresentanteRepository->findByEstudianteId($estudianteId);
        
         return new Response($this->serializer->serialize($estudianteRepresentantes, 'json'));
    }
    
    #[Route('/estudiante/{estudianteId}/representante/principal', name: 'app_estudiante_representante_principal', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function showPrincipal(int $estudianteId): Response
    { 
        $estudianteRepresentante =  $this->estudianteRepresentanteRepository->findOneBy([
            "estudiante"=>$estudianteId,
            "esPrincipal"=>true
        ]);     
        
         if(!$estudianteRepresentante){
            throw new NotFoundHttpException('EstudianteRepresentante no existe');
         }
        
        return new Response($this->serializer->serialize($estudianteRepresentante, 'json'), Response::HTTP_OK);
    }

    #[Route('/estudiante/{estudianteId}/representante/alternativos', name: 'app_estudiante_representante_alternativos')]
    public function listAlternativos(int $estudianteId): Response
    {
        $estudianteRepresentantes = $this->estudianteRepresentanteRepository->findBy([
            "estudiante"=>$estudianteId,
            "esPrincipal"=>false
        ]);

        return new Response($this->serializer->serialize($estudianteRepresentantes, 'json'));
    }

    #[Route('/estudiante/{estudianteId}/representante/create', name: 'app_estudiante_representante_create', methods: ['POST'], defaults: ["_format"=>"json"])]
    public function create(int $estudianteId, Request $request): Response
    {                   
        $estudianteRepresentante = $this->serializer->deserialize($request->getContent(), EstudianteRepresentante::class, 'json');
        $estudianteRepresentante->setEstudiante($this->estudianteRepository->find($estudianteId));

        $errors = $this->validator->validate($estudianteRepresentante);

        if (count($errors) > 0) {
            throw new InvalidArgumentException((string) $errors);
        }
        
        if($estudianteRepresentante->isEsPrincipal()===false){

            $representantePrincipalExistente = $this->estudianteRepresentanteRepository->findOneBy([
                "estudiante"=>$estudianteRepresentante->getEstudiante(),
                "esPrincipal"=>true
            ]);

            if(!$representantePrincipalExistente){
                throw new InvalidArgumentException('El estudiante debe tener un representante principal');
            }
        }else{
            $this->preCreateOrUpdateChangue($estudianteRepresentante);
        }

        //Guarda el objecto nuevo
        $this->entityManager->persist($estudianteRepresentante);
        $this->entityManager->flush();
        
        return new Response($this->serializer->serialize($estudianteRepresentante, 'json'), Response::HTTP_OK);
    }
    
    #[Route('/estudiante/{estudianteId}/representante/update/{id}', name: 'app_estudiante_representante_update', methods: ['PUT'], defaults: ["_format"=>"json"])]
    public function update(int $estudianteId, int $id, Request $request): Response
    {
        $estudianteRepresentante =  $this->estudianteRepresentanteRepository->findOneBy([
                'estudiante'=>$estudianteId,
                'id'=>$id]
        );

        /*validación en caso que el objeto actual es principal en la BD, y los datos que llega es_principal es igual a false
          no se puede setear el representante principal a false, motivos que no quedaria un representante principal*/
        $data = json_decode($request->getContent());
        if($estudianteRepresentante->isEsPrincipal() && $data->es_principal===false){
            throw new InvalidArgumentException('El estudiante debe tener un representante principal');
        }
        
        //deserializacion de datos
        $context = new DeserializationContext();
        
        $context->setAttribute('target', $estudianteRepresentante);
        $updatedEstudianteRepresentante = $this->serializer->deserialize($request->getContent(), EstudianteRepresentante::class, 'json', $context);
        
        //Validación del objeto
        $errors = $this->validator->validate($updatedEstudianteRepresentante);
        
        if (count($errors) > 0) {
            throw new InvalidArgumentException((string) $errors);
        }
        
        if($estudianteRepresentante->isEsPrincipal()===true){
             $this->preCreateOrUpdateChangue($updatedEstudianteRepresentante);
        }
        
        //guarda en la base de datos los cambios realizados
        $this->entityManager->persist($updatedEstudianteRepresentante);
        $this->entityManager->flush();
        
        //response serialize
        return new Response($this->serializer->serialize($updatedEstudianteRepresentante, 'json'), Response::HTTP_OK);
    }
    
    #[Route('/estudiante/{estudianteId}/representante/delete/{id}', name: 'app_estudiante_representante_delete', methods: ['DELETE'], defaults: ["_format"=>"json"])]
    public function delete(int $estudianteId, int $id): Response
    { 
        $estudianteRepresentante =  $this->estudianteRepresentanteRepository->findOneBy([
            'estudiante'=>$estudianteId,
             'id'=>$id]
        );

        if(!$estudianteRepresentante){
            throw new NotFoundHttpException('EstudianteRepresentante no existe');
        }

        if($estudianteRepresentante->isEsPrincipal()){
            throw new NotFoundHttpException('No puede eliminar el representante principal');
        }

        $this->entityManager->remove($estudianteRepresentante);
        $this->entityManager->flush();
        
        return new Response($this->serializer->serialize($estudianteRepresentante, 'json'), Response::HTTP_OK);
    }
    
    private function preCreateOrUpdateChangue(EstudianteRepresentante $estudianteRepresentanteActual)
    {
        //cuando se crea un estudianteRepresentante
        if(!$estudianteRepresentanteActual->getId()){ 
                $estudianteRepresentanteExistente = $this->estudianteRepresentanteRepository->findOneBy([
                    "estudiante"=>$estudianteRepresentanteActual->getEstudiante(),
                    "esPrincipal"=>true
                ]); 
        //cuando se actualiza un estudianteRepresentante, obtenemos es el estudianteRepresentanteExistente siempre cuando no sea e mismo del actual
        }else{ 
            $estudianteRepresentanteExistente = $this->estudianteRepresentanteRepository->findByEstdudianteExceptRepresentanteOne($estudianteRepresentanteActual->getEstudiante()->getId(), $estudianteRepresentanteActual->getId());
        }
        
        //cambiamos el estudianteRepresentante esistente a false
        if($estudianteRepresentanteExistente){
            $estudianteRepresentanteExistente->setEsPrincipal(false);
            $this->entityManager->persist($estudianteRepresentanteExistente);
        } 
    }
}
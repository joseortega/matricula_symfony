<?php

namespace App\Controller;

use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('api')]
class UserController extends AbstractController
{
    public function __construct(
        private Security $security,
        private SerializerInterface $serializer,)
    {
    }

    #[Route('/me', name: 'app_user_me', methods: ['GET'])]
    public function me(): Response
    {
        $user = $this->security->getUser();

        if(!$user){
            return $this->json(['message' => 'missing credentials'], Response::HTTP_UNAUTHORIZED);
        }

        return new Response($this->serializer->serialize($user, 'json'));

    }

    #[Route('/logout', name: 'app_user_logout', methods: ['GET'])]
    public function logout(): JsonResponse
    {
        // No se necesita lógica adicional para JWT puro
        return new JsonResponse(['message' => 'Logout successful'], 200);
    }
}

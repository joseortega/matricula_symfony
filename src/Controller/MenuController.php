<?php

namespace App\Controller;

use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
#[Route('api')]
class MenuController extends AbstractController
{
    public function __construct(private Security $security)
    {
    }

    #[Route('/me/menu', name: 'api_menu', methods: ['GET'])]
    public function getMenu(): JsonResponse
    {
        // Aquí puedes personalizar el menú según el rol del usuario
        $user = $this->security->getUser();
        $menu = [
            ['route' => 'matricula', 'name' => 'matricula', 'type' => 'link', 'icon'=>'app_registration'],
            ['route' => 'expediente/retiro', 'name' => 'expediente-retiro', 'type' => 'link', 'icon'=>'drive_file_move'],
        ];

        // Ejemplo de menú basado en roles
        if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
            $menu[] = ['title' => 'Admin', 'link' => '/admin', 'icon' => 'admin_panel_settings'];
        }

        return new JsonResponse(['menu' => $menu]);
    }
}

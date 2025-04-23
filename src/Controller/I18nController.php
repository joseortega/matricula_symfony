<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('api')]
class I18nController extends AbstractController
{
    #[Route('/i18n/{filename}', name: 'app_i18n', methods: ['GET'], defaults: ["_format"=>"json"])]
    public function serveFile(string $filename): Response
    {
        $filePath = __DIR__ . '/../../translations/' . $filename;

        if (!file_exists($filePath) || pathinfo($filePath, PATHINFO_EXTENSION) !== 'json') {
            return new Response('File not found', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(json_decode(file_get_contents($filePath), true));
    }
}

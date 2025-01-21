<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiDocsController extends AbstractController
{
    #[Route('/api/docs', name: 'app_api_docs')]
    public function index(): Response
    {
        return $this->render('api_docs/index.html.twig', [
            'swagger_json_url' => '/openapi.json',
        ]);
    }
}

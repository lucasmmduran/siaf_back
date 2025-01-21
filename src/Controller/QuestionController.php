<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class QuestionController extends AbstractController
{
    #[Route('/api/questions', methods: ["GET"], name: 'app_question')]
    #[OA\Tag(name: 'Questions')]
    public function index(): Response
    {
        // query db
        
        return new JsonResponse();
    }
}

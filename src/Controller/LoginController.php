<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class LoginController
{
    #[Route('/api/login_check', methods: ['POST'])]
    #[OA\Post(
        tags: ['Auth'],
        path: '/api/login_check',
        summary: 'Generates a JWT token for the user.',
        description: 'This endpoint generates a JWT token for the authenticated user.',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/Credentials')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'JWT Token Generated.',
                content: new OA\JsonContent(ref: '#/components/schemas/Token')
            ),
            new OA\Response(response: 401, description: 'Invalid credentials.'),
        ],
    )]
    public function login(): Response
    {
        throw new \RuntimeException('Login handled by LexikJWT.');
    }
}

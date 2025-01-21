<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[OA\Info(
    title: "API Documentation",
    version: "1.0.0"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    
    
    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/api/users', methods: ["GET"], name: 'app_users')]
    #[OA\Get(
        tags: ["Users"],
        path: "/api/users",
        summary: "Retrieve all users",
        description: "Retrieves a list of all registered users. Requires authentication.",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of users",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        ref: "#/components/schemas/User"
                    ),
                    example: [
                        [
                            "id" => 123,
                            "email" => "test@example.com",
                        ],
                        [
                            "id" => 456,
                            "email" => "another@example.com",
                        ],
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Unauthorized. Missing or invalid token."),
            new OA\Response(response: 500, description: "Internal Server Error.")
        ]
    )]
    public function index(): JsonResponse
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        return $this->json($users, JsonResponse::HTTP_OK, [], ['groups' => 'user:read']);
    }

    #[Route('api/users/{id}', methods:["GET"], name: 'app_user_show')]
    #[OA\Get(
        tags: ["Users"],
        path: "/api/users/{id}",
        summary: "Retrieve user by ID",
        description: "Retrieves detailed information for a specific user based on their ID. Requires authentication.",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "User data",
                content: new OA\JsonContent(
                    type: "object",
                    ref: "#/components/schemas/User",
                    example: [
                        "id" => 123,
                        "email" => "test@example.com",
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Unauthorized. Missing or invalid token."),
            new OA\Response(response: 404, description: "User not found."),
            new OA\Response(response: 500, description: "Internal Server Error.")
        ]
    )]
    public function show(int $id, UserRepository $repository): JsonResponse
    {
        try {
            $data = $repository->findOrFail($id);
            return $this->json($data, JsonResponse::HTTP_OK, [], ['groups' => 'user:read']);
        } catch (NotFoundHttpException $e) {
            return new JsonResponse(
                [
                    'status' => JsonResponse::HTTP_NOT_FOUND,
                    'message' => $e->getMessage(),
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
    }

    /* #[Route('api/users', methods:["POST"], name: 'app_user_create')]
    #[OA\Tag(name: 'Users')]
    public function create(Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $data = json_decode($request->getContent(), true);  
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->json(
                ['error' => 'Invalid form data', 'details' => (string) $form->getErrors(true, false)],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        
        $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json($user, JsonResponse::HTTP_CREATED);
    } */

    

    /* #[Route('api/users/{id}', methods:["PUT"], name: 'app_user_update')]
    #[OA\Tag(name: 'Users')]
    public function update()
    {
        //
    } */

    /* #[Route('api/users/{id}', methods:["DELETE"], name: 'app_user_delete')]
    #[OA\Tag(name: 'Users')]
    public function delete()
    {
        //
    } */ 
}

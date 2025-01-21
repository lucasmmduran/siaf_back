<?php

namespace App\Controller;

use App\Entity\Form;
use App\Repository\FormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/forms', methods: ["GET"])]
    #[OA\Get(
        tags: ["Forms"],
        path: "/api/forms",
        summary: "Retrieve all forms",
        description: "Retrieves a list of all forms. Requires authentication.",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of forms",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        ref: "#/components/schemas/Form"
                    ),
                    example: [
                        [
                            "id" => 1234,
                            "title" => "My awesome form",
                            "description" => "This is a basic form.",
                            "level" => [
                                "id" => 1,
                                "title" => "Basic"
                            ],
                            "createdByUser" => [
                                "id" => 1,
                                "email" => "text@example.com"
                            ],
                        ],
                        [
                            "id" => 5678,
                            "title" => "A new form",
                            "description" => "This is an intermediate form.",
                            "level" => [
                                "id" => 1,
                                "title" => "Intermediate"
                            ],
                            "createdByUser" => [
                                "id" => 1,
                                "email" => "text@example.com"
                            ],
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
        $forms = $this->entityManager->getRepository(Form::class)->findAll();
        return $this->json($forms, JsonResponse::HTTP_OK, [], ['groups' => 'user:read']);
    }

    #[Route('api/forms/{id}', methods:["GET"])]
    #[OA\Get(
        tags: ["Forms"],
        path: "/api/forms/{id}",
        summary: "Retrieve form by ID",
        description: "Retrieves detailed information for a specific form based on their ID. Requires authentication.",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Form data",
                content: new OA\JsonContent(
                    type: "object",
                    ref: "#/components/schemas/Form",
                    /* example: [
                        "id" => 123,
                        "email" => "test@example.com",
                    ] */
                )
            ),
            new OA\Response(response: 401, description: "Unauthorized. Missing or invalid token."),
            new OA\Response(response: 404, description: "User not found."),
            new OA\Response(response: 500, description: "Internal Server Error.")
        ]
    )]
    public function show(int $id, FormRepository $repository): JsonResponse
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

    /* #[Route('/new', name: 'app_form_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = new Form();
        $form = $this->createForm(FormType::class, $form);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form);
            $entityManager->flush();

            return $this->redirectToRoute('app_form_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('form/new.html.twig', [
            'form' => $form,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_form_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Form $form, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormType::class, $form);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_form_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('form/edit.html.twig', [
            'form' => $form,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_form_delete', methods: ['POST'])]
    public function delete(Request $request, Form $form, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$form->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($form);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_form_index', [], Response::HTTP_SEE_OTHER);
    } */
}

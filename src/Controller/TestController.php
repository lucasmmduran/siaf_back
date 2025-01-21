<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/api/cabecera', methods:['POST'])]
    public function index(Request $request): JsonResponse
    {
        $data = $request->toArray();
        return new JsonResponse([$data], 200);
        //dd($data);
    }
}

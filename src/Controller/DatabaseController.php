<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class DatabaseController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/check-database', methods: ['GET'], name: 'check_database')]
    public function checkDatabase(): Response
    {
        try {
            $this->entityManager->getConnection()->connect();
            return new Response('Conexión a la base de datos exitosa.');
        } catch (\Exception $e) {
            return new Response('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }
}

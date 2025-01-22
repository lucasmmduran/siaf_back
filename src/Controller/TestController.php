<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/api/cabecera', methods:['POST'])]
    public function index(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $data['id'] = 901;

        return new JsonResponse([
            'success' => true,
            'data' => [$data]
        ], JsonResponse::HTTP_OK);
    }

    #[Route('/api/get_plans', methods:['GET'])]
    public function getPlans(): JsonResponse
    {
        $plans = 
        [
            [
                'id' => 123,
                'anio' => 2020,
                'unidad' => 'Unidad I',
                'identificacion_plan' => 'Convenios',
                'nro_plan' => 'Planta Permanente',
                'fecha_ingreso' => '2024-01-01',
                'fecha_ult_actualizacion' => '2024-03-01',
            ],
            [
                'id' => 456,
                'anio' => 2021,
                'unidad' => 'Unidad II',
                'identificacion_plan' => 'RRHH',
                'nro_plan' => 'Ley Marco',
                'fecha_ingreso' => '2024-03-01',
                'fecha_ult_actualizacion' => '2024-06-01',
            ]
        ];

        return new JsonResponse([
            'success' => true,
            'data' => $plans
        ], JsonResponse::HTTP_OK);
    }

    #[Route('/api/get_proccess', methods:['GET'])]
    public function getProccess(): JsonResponse
    {
        $procesos = 
        [
            [
                'id' => 404,
                'pla_planes_cabecera_id' => '123',
                'nro_linea' => '123',
                'descripcion' => 'Acá va una descripción que permita identificar de que se trata el proceso y si es necesario su justificación.',
                'nombre' => 'Universidades',
                'identificacion' => '123',
                'es_plurianual' => '123',
                'es_moneda_extranjera' => '123',
                'esta_presupuestado' => '123',
                'tipo_tasa' => '123',
                'tasa_conversion' => '123',
                'importe_total' => '123',
                'importe_total_orig' => '123',
                'importe_ejercicio' => '123',
                'importe_ejercicio_orig' => '123',
                'importe_anterior_orig' => '123',
                'importe_proximo_ejercicio_orig' => '123',
                'expediente_impulso' => '123',
                'tipo_registro' => '123',
                'referencia_linea_proceso' => '123',
            ],
            [
                'id' => 502,
                'pla_planes_cabecera_id' => '123',
                'nro_linea' => '123',
                'descripcion' => 'Acá va una descripción que permita identificar de que se trata el proceso y si es necesario su justificación.',
                'nombre' => 'ONG',
                'identificacion' => '123',
                'es_plurianual' => '123',
                'es_moneda_extranjera' => '123',
                'esta_presupuestado' => '123',
                'tipo_tasa' => '123',
                'tasa_conversion' => '123',
                'importe_total' => '123',
                'importe_total_orig' => '123',
                'importe_ejercicio' => '123',
                'importe_ejercicio_orig' => '123',
                'importe_anterior_orig' => '123',
                'importe_proximo_ejercicio_orig' => '123',
                'expediente_impulso' => '123',
                'tipo_registro' => '123',
                'referencia_linea_proceso' => '123',
            ],
            
        ];

        return new JsonResponse([
            'success' => true,
            'data' => $procesos
        ], JsonResponse::HTTP_OK);
    }
}

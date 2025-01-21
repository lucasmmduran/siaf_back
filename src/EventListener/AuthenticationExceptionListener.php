<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTExpiredTokenException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();
        
        if ($request->getMethod() === 'POST' && $request->getPathInfo() === '/api/login_check') {
            $data = json_decode($request->getContent(), true);
            if (empty($data['username'])) {
                $message = 'El usuario no puede estar vacío.';
                $response = new JsonResponse([
                    'code' => 400,
                    'message' => $message,
                ], 400);
                $event->setResponse($response);
                return;
            }
        }

        /* if ($exception instanceof JWTExpiredTokenException) {
            $message = 'El token ha expirado. Por favor, inicia sesión nuevamente.';
            $response = new JsonResponse([
                'code' => 401,
                'message' => $message,
            ], 401);
            $event->setResponse($response);
        } */

        if ($exception instanceof BadRequestHttpException) {
            $message = 'La contraseña no puede estar vacía.';
            $response = new JsonResponse([
                'code' => 400,
                'message' => $message,
            ], 400);
            $event->setResponse($response);
        }
    }
}

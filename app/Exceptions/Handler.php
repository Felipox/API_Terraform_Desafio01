<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        // Não autenticado
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        // Sem permissão
        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        // Validação
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => 'Invalid data',
                'errors'  => $exception->errors()
            ], 422);
        }

        // Model não encontrado (ex: User::findOrFail(99))
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Resource not found'
            ], 404);
        }

        // Rota não encontrada
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Route not found'
            ], 404);
        }

        // Método HTTP não permitido (POST em rota GET, etc)
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'message' => 'Method not allowed'
            ], 405);
        }

        // Qualquer outro erro inesperado
        return response()->json([
            'message' => 'Internal server error'
        ], 500);
    }
}
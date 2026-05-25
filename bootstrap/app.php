<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php'
    )
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->job(new \App\Jobs\DataBaseConnectionJob())
            ->everyThirtySeconds();
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
        \Illuminate\Http\Middleware\HandleCors::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (AuthenticationException $e, $request) {
            return response()->json(['message' => 'Unauthorized'], 403);
        });

        $exceptions->render(function (AuthorizationException $e, $request) {
            return response()->json(['message' => 'Forbidden'], 403);
        });

        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'message' => 'Invalid data',
                'errors'  => $e->errors()
            ], 422);
        });

        $exceptions->render(function (ModelNotFoundException $e, $request) {
            return response()->json(['message' => 'Resource not found'], 404);
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json(['message' => 'Route not found'], 404);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json(['message' => 'Method not allowed'], 405);
        });

        $exceptions->render(function (Throwable $e, $request) {
            return response()->json(['message' => 'Internal server error'], 500);
        });

    })->create();
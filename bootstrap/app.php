<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
        $middleware->alias([
            'role' =>
            \Spatie\Permission\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (
            Throwable $e,
            $request
        ) {

            if ($request->is('api/*')) {

                $statusCode = 500;
                $message = 'Internal Server Error';

                // HTTP Exception
                if (
                    $e instanceof
                    \Symfony\Component\HttpKernel\Exception\HttpException
                ) {

                    $statusCode =
                        $e->getStatusCode();

                    $message =
                        $e->getMessage()
                        ?: match ($statusCode) {

                            401 =>
                            'Unauthorized',

                            403 =>
                            'Forbidden',

                            404 =>
                            'Resource not found',

                            default =>
                            'Something went wrong'
                        };
                }

                return response()->json([
                    'success' => false,
                    'message' => $message
                ], $statusCode);
            }
        });
    })->create();

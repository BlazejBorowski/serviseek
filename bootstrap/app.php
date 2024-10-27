<?php

use App\Exceptions\InternalException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Nette\NotImplementedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web/core.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (InternalException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], $e->getCode() ?: 500);
            }

            return response()->view('errors.custom-exception', [
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        });

        $exceptions->render(function (NotImplementedException $e) {
            return response()->view('errors.not_implemented', [
                'message' => $e->getMessage(),
            ], 501);
        });
    })->create();

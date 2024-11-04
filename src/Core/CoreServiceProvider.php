<?php

declare(strict_types=1);

namespace Core;

use BlazejBorowski\LaravelCqrs\Query\QueryBus;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;
use Modules\Services\Queries\ServicesListQuery;
use Modules\Services\Queries\ServicesListQueryHandler;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $queryBus = app(QueryBus::class);

        $queryBus->register([
            ServicesListQuery::class => ServicesListQueryHandler::class,
        ]);

        EnsureFeaturesAreActive::whenInactive(
            function (Request $request, array $features) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'error' => 'Feature is inactive',
                    ], 403);
                }

                return response()->view('errors.feature_is_inactive', [
                    'message' => 'Feature is inactive',
                ], 403);
            }
        );
    }
}

<?php

declare(strict_types=1);

namespace Core;

use BlazejBorowski\LaravelCqrs\Query\QueryBus;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;
use Modules\Services\Queries\GetServiceQuery\GetServiceQuery;
use Modules\Services\Queries\GetServiceQuery\GetServiceQueryHandler;
use Modules\Services\Queries\ListServicesQuery\ListServicesQuery;
use Modules\Services\Queries\ListServicesQuery\ListServicesQueryHandler;
use Symfony\Component\HttpFoundation\Response;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $queryBus = app(QueryBus::class);

        $queryBus->register([
            GetServiceQuery::class => GetServiceQueryHandler::class,
            ListServicesQuery::class => ListServicesQueryHandler::class,
        ]);

        EnsureFeaturesAreActive::whenInactive(
            function (Request $request, array $features) {
                abort(Response::HTTP_NOT_FOUND);
            }
        );
    }
}

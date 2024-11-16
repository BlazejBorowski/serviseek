<?php

declare(strict_types=1);

namespace Core\Http\Controllers;

use App\Http\Controllers\Controller;
use BlazejBorowski\LaravelCqrs\Query\QueryBus;
use Core\Dtos\Response\DashboardResponseDto;
use Core\Http\Requests\DashboardRequest;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Services\Queries\ListServicesQuery\ListServicesQuery;
use Modules\Services\ValueObjects\Service;

class CoreController extends Controller
{
    public function __construct(
        private QueryBus $queryBus
    ) {}

    public function dashboard(DashboardRequest $request): Response
    {
        /** @var Collection<int, Service> $services */
        $services = $this->queryBus->ask(new ListServicesQuery(
            relations: ['category', 'tags', 'mainImage', 'mainEmail', 'mainPhone'],
            columns: ['id', 'name', 'description']
        ));

        $responseDto = new DashboardResponseDto(
            $services,
        );

        return Inertia::render('Dashboard', $responseDto->getData());
    }
}

<?php

declare(strict_types=1);

namespace Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use BlazejBorowski\LaravelCqrs\Query\QueryBus;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Services\Dtos\Requests\IndexServiceRequestDto;
use Modules\Services\Dtos\Requests\ShowServiceRequestDto;
use Modules\Services\Dtos\Responses\IndexServiceResponseDto;
use Modules\Services\Dtos\Responses\ShowServiceResponseDto;
use Modules\Services\Http\Requests\IndexServiceRequest;
use Modules\Services\Http\Requests\ShowServiceRequest;
use Modules\Services\Http\Requests\StoreServiceRequest;
use Modules\Services\Http\Requests\UpdateServiceRequest;
use Modules\Services\Models\Service;
use Modules\Services\Queries\GetServiceQuery\GetServiceQuery;
use Modules\Services\Queries\ListServicesQuery\ListServicesQuery;
use Modules\Services\ValueObjects\Service as ValueObjectService;
use Nette\NotImplementedException;

class ServiceController extends Controller
{
    public function __construct(
        private QueryBus $queryBus
    ) {}

    public function index(IndexServiceRequest $request): Response
    {
        $requestDto = new IndexServiceRequestDto($request->getData());

        /** @var Collection<int, ValueObjectService> $services */
        $services = $this->queryBus->ask(new ListServicesQuery(
            filterValue: $requestDto->getFilterValue(),
            filterColumn: 'name',
            relations: ['category', 'tags', 'mainImage', 'mainEmail', 'mainPhone'],
            columns: ['id', 'name', 'description'],
            limit: $requestDto->getLimit(),
            offset: $requestDto->getOffset(),
            category: $requestDto->getCategory(),
            tag: $requestDto->getTag(),
        ));

        $responseDto = new IndexServiceResponseDto(
            $services,
        );

        return Inertia::render('Services/List', $responseDto->getData());
    }

    public function create(): void
    {
        throw new NotImplementedException;
    }

    public function store(StoreServiceRequest $request): void
    {
        throw new NotImplementedException;
    }

    public function show(ShowServiceRequest $request): Response
    {
        $requestDto = new ShowServiceRequestDto($request->getData());

        /**
         * @var ValueObjectService
         */
        $service = $this->queryBus->ask(new GetServiceQuery(
            filterValue: $requestDto->getServiceId(),
            relations: ['images', 'emails', 'phones', 'tags'],
            columns: ['id', 'name', 'description']
        ));

        $responseDto = new ShowServiceResponseDto(
            $service
        );

        return Inertia::render('Services/Show', $responseDto->getData());
    }

    public function edit(Service $service): void
    {
        throw new NotImplementedException;
    }

    public function update(UpdateServiceRequest $request, Service $service): void
    {
        throw new NotImplementedException;
    }

    public function destroy(Service $service): void
    {
        throw new NotImplementedException;
    }
}

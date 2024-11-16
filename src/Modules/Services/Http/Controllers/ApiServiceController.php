<?php

declare(strict_types=1);

namespace Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use BlazejBorowski\LaravelCqrs\Query\QueryBus;
use Illuminate\Support\Collection;
use Modules\Services\Dtos\Requests\ApiIndexServiceRequestDto;
use Modules\Services\Dtos\Responses\ApiIndexServiceResponseDto;
use Modules\Services\Http\Requests\ApiIndexServiceRequest;
use Modules\Services\Http\Resources\ServiceCollection;
use Modules\Services\Queries\ListServicesQuery\ListServicesQuery;
use Modules\Services\ValueObjects\Service;

class ApiServiceController extends Controller
{
    public function __construct(
        private QueryBus $queryBus
    ) {}

    public function index(ApiIndexServiceRequest $request): ServiceCollection
    {
        $requestDto = new ApiIndexServiceRequestDto($request->getData());

        /** @var Collection<int, Service> $services */
        $services = $this->queryBus->ask(new ListServicesQuery(
            filterValue: $requestDto->getFilterValue(),
            filterColumn: 'name',
            columns: ['id', 'name', 'description'],
            limit: $requestDto->getLimit(),
            offset: $requestDto->getOffset(),
            category: $requestDto->getCategory(),
            tag: $requestDto->getTag(),
            relations: ['category', 'tags', 'mainImage', 'mainEmail', 'mainPhone'],
        ));

        $responseDto = new ApiIndexServiceResponseDto($services);

        return new ServiceCollection($responseDto->getData());
    }
}

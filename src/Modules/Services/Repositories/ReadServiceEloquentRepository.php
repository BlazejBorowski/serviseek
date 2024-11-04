<?php

declare(strict_types=1);

namespace Modules\Services\Repositories;

use Illuminate\Support\Collection;
use Modules\Services\Models\Service;
use Modules\Services\Queries\ServicesListQuery;
use Modules\Services\ValueObjects\Service as ValueObjectService;

class ReadServiceEloquentRepository implements ReadServiceRepository
{
    /**
     * @return Collection<int, ValueObjectService>
     */
    public function getListing(ServicesListQuery $query): Collection
    {
        $services = Service::with(['emails', 'phones', 'category', 'tags', 'images'])
            ->limit($query->getLimit())
            ->offset($query->getOffset())
            ->when(! empty($query->getCategories()), function ($queryBuilder) use ($query) {
                $queryBuilder->whereIn('category_id', $query->getCategories());
            })
            ->when(! empty($query->getTags()), function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('tags', function ($tagQuery) use ($query) {
                    $tagQuery->whereIn('name', $query->getTags());
                });
            })
            ->get()
            ->map($this->mapToService());

        return $services;
    }

    private function mapToService(): callable
    {
        return fn (Service $data): ValueObjectService => new ValueObjectService($data->toArray());
    }
}

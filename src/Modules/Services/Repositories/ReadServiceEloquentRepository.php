<?php

declare(strict_types=1);

namespace Modules\Services\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Services\Models\Service;
use Modules\Services\Queries\GetServiceQuery\GetServiceQuery;
use Modules\Services\Queries\ListServicesQuery\ListServicesQuery;
use Modules\Services\Repositories\Criteria\CategoryCriterion;
use Modules\Services\Repositories\Criteria\FilterCriterion;
use Modules\Services\Repositories\Criteria\LimitCriterion;
use Modules\Services\Repositories\Criteria\OffsetCriterion;
use Modules\Services\Repositories\Criteria\SelectColumnsCriterion;
use Modules\Services\Repositories\Criteria\SelectRelationsCriterion;
use Modules\Services\Repositories\Criteria\TagCriterion;
use Modules\Services\ValueObjects\Service as ValueObjectService;

class ReadServiceEloquentRepository implements ReadServiceRepository
{
    /**
     * @return Collection<int, ValueObjectService>
     */
    public function getListing(ListServicesQuery $query): Collection
    {
        $builder = $this->getBaseQuery();

        $criteria = [
            new SelectRelationsCriterion($query),
            new SelectColumnsCriterion($query),
            new FilterCriterion($query),
            new CategoryCriterion($query),
            new TagCriterion($query),
            new LimitCriterion($query),
            new OffsetCriterion($query),
        ];

        foreach ($criteria as $criterion) {
            if ($criterion->shouldApply()) {
                $builder = $criterion->apply($builder);
            }
        }

        $services = $builder->get()->map($this->mapToService());

        return $services;
    }

    public function get(GetServiceQuery $query): ValueObjectService
    {
        $builder = $this->getBaseQuery();

        $criteria = [
            new SelectRelationsCriterion($query),
            new SelectColumnsCriterion($query),
            new FilterCriterion($query),
        ];

        foreach ($criteria as $criterion) {
            if ($criterion->shouldApply()) {
                $builder = $criterion->apply($builder);
            }
        }

        /**
         * @var Service
         */
        $service = $builder->firstOrFail();

        return $service->toValueObject();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder<Service>
     */
    private function getBaseQuery(): Builder
    {
        return Service::query();
    }

    private function mapToService(): callable
    {
        return fn (Service $data): ValueObjectService => $data->toValueObject();
    }
}

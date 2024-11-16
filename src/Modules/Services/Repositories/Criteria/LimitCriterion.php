<?php

declare(strict_types=1);

namespace Modules\Services\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Modules\Services\Models\Service;
use Modules\Services\Queries\ServiceQueryInterface;

class LimitCriterion
{
    public function __construct(private ServiceQueryInterface $query) {}

    public function shouldApply(): bool
    {
        return $this->query->getLimit() !== null;
    }

    /**
     * @param  Builder<Service>  $query
     * @return Builder<Service>
     */
    public function apply(Builder $query): Builder
    {
        return $query->limit($this->query->getLimit());
    }
}

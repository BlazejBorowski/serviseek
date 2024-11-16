<?php

declare(strict_types=1);

namespace Modules\Services\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Modules\Services\Models\Service;
use Modules\Services\Queries\ServiceQueryInterface;

class CategoryCriterion
{
    public function __construct(private ServiceQueryInterface $query) {}

    public function shouldApply(): bool
    {
        return ! empty($this->query->getCategory());
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<Service>  $query
     * @return \Illuminate\Database\Eloquent\Builder<Service>
     */
    public function apply(Builder $query): Builder
    {
        return $query->where('category_id', $this->query->getCategory());
    }
}

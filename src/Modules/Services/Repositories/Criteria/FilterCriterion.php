<?php

declare(strict_types=1);

namespace Modules\Services\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Modules\Services\Models\Service;
use Modules\Services\Queries\ServiceQueryInterface;

class FilterCriterion
{
    public function __construct(private ServiceQueryInterface $query) {}

    public function shouldApply(): bool
    {
        return ! empty($this->query->getFilterColumn()) && ! empty($this->query->getFilterValue());
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<Service>  $query
     * @return \Illuminate\Database\Eloquent\Builder<Service>
     */
    public function apply(Builder $query): Builder
    {
        $filterValue = (string) $this->query->getFilterValue();
        $words = explode(' ', $filterValue);
        foreach ($words as $word) {
            $query->where($this->query->getFilterColumn(), 'like', '%'.$word.'%');
        }

        return $query;
    }
}

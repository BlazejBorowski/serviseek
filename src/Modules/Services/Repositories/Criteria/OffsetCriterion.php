<?php

declare(strict_types=1);

namespace Modules\Services\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Modules\Services\Models\Service;
use Modules\Services\Queries\ServiceQueryInterface;

class OffsetCriterion
{
    public function __construct(private ServiceQueryInterface $query) {}

    public function shouldApply(): bool
    {
        return $this->query->getOffset() !== null;
    }

    /**
     * @param  Builder<Service>  $query
     * @return Builder<Service>
     */
    public function apply(Builder $query): Builder
    {
        return $query->offset($this->query->getOffset());
    }
}

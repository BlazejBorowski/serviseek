<?php

declare(strict_types=1);

namespace Modules\Services\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Modules\Services\Models\Service;
use Modules\Services\Queries\ServiceQueryInterface;

class SelectRelationsCriterion
{
    public function __construct(private ServiceQueryInterface $query) {}

    public function shouldApply(): bool
    {
        return ! empty($this->query->getRelations());
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<Service>  $query
     * @return \Illuminate\Database\Eloquent\Builder<Service>
     */
    public function apply(Builder $query): Builder
    {
        $relations = $this->query->getRelations();
        if (! empty($relations)) {
            $this->addRelationColumns($query, $relations);
            $query->with($this->query->getRelations());
        }

        return $query;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<Service>  $query
     * @param  array<string>  $relations
     */
    private function addRelationColumns(Builder $query, array $relations): void
    {
        $relationKeys = [
            'category' => 'category_id',
        ];

        foreach ($relations as $relation) {
            if (array_key_exists($relation, $relationKeys)) {
                $query->addSelect($relationKeys[$relation]);
            }
        }
    }
}

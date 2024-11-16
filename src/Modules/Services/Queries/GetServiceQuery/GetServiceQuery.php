<?php

declare(strict_types=1);

namespace Modules\Services\Queries\GetServiceQuery;

use BlazejBorowski\LaravelCqrs\Query\Query;
use Modules\Services\Queries\ServiceQueryInterface;

class GetServiceQuery extends Query implements ServiceQueryInterface
{
    public function __construct(
        private string $filterValue,
        private string $filterColumn = 'id',
        /** @var array<string> */ private array $relations = [],
        /** @var array<string> */ private array $columns = ['*'],

    ) {}

    public function getFilterColumn(): string
    {
        return $this->filterColumn;
    }

    public function getFilterValue(): ?string
    {
        return $this->filterValue ?? null;
    }

    /**
     * @return array<string>
     */
    public function getRelations(): array
    {
        return $this->relations;
    }

    /**
     * @return array<string>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getOffset(): int
    {
        return 0;
    }

    public function getLimit(): int
    {
        return 1;
    }

    public function getTag(): string
    {
        return '';
    }

    public function getCategory(): int
    {
        return 0;
    }
}

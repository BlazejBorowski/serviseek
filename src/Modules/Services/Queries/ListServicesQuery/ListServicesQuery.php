<?php

declare(strict_types=1);

namespace Modules\Services\Queries\ListServicesQuery;

use BlazejBorowski\LaravelCqrs\Query\Query;
use Modules\Services\Queries\ServiceQueryInterface;

/**
 * @phpstan-import-type ServiceCategoryData from \Modules\Services\ValueObjects\ServiceCategory
 * @phpstan-import-type ServiceTagData from \Modules\Services\ValueObjects\ServiceTag
 *
 * @phpstan-type ListServicesQueryData array{
 *     limit: int,
 *     offset: int,
 *     category: int|null,
 *     tag: string|null
 * }
 */
class ListServicesQuery extends Query implements ServiceQueryInterface
{
    public function __construct(
        private int $limit = 10,
        private int $offset = 0,
        private ?int $category = null,
        private ?string $tag = null,
        /** @var array<string> */ private array $columns = ['*'],
        private ?string $filterValue = null,
        private string $filterColumn = 'id',
        /** @var array<string> */ private array $relations = [],
    ) {}

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getCategory(): ?int
    {
        return $this->category ?? null;
    }

    public function getTag(): ?string
    {
        return $this->tag ?? null;
    }

    /**
     * @return ListServicesQueryData
     */
    public function getQuery(): array
    {
        return [
            'limit' => $this->limit,
            'offset' => $this->offset,
            'category' => $this->category,
            'tag' => $this->tag,
        ];
    }

    public function getFilterColumn(): string
    {
        return $this->filterColumn;
    }

    public function getFilterValue(): ?string
    {
        return $this->filterValue ?? null;
    }

    public function getRelations(): array
    {
        return $this->relations;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }
}

<?php

declare(strict_types=1);

namespace Modules\Services\Queries;

use BlazejBorowski\LaravelCqrs\Query\Query;

/**
 * @phpstan-import-type ServiceCategoryData from \Modules\Services\ValueObjects\ServiceCategory
 * @phpstan-import-type ServiceTagData from \Modules\Services\ValueObjects\ServiceTag
 *
 * @phpstan-type ListServicesQueryData array{
 *     limit: int,
 *     offset: int,
 *     categories: array<int>,
 *     tags: array<string>
 * }
 */
class ServicesListQuery extends Query
{
    private int $limit;

    private int $offset;

    /** @var array<int> */
    private array $categories;

    /** @var array<string> */
    private array $tags;

    /**
     * @param  array<int>  $categories
     * @param  array<string>  $tags
     */
    public function __construct(
        int $limit = 10,
        int $offset = 0,
        array $categories = [],
        array $tags = []
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->categories = $categories;
        $this->tags = $tags;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return array<int>
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return array<string>
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return ListServicesQueryData
     */
    public function getQuery(): array
    {
        return [
            'limit' => $this->limit,
            'offset' => $this->offset,
            'categories' => $this->categories,
            'tags' => $this->tags,
        ];
    }
}

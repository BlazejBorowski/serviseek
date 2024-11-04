<?php

declare(strict_types=1);

namespace Modules\Services\Dtos\Requests;

class ApiIndexServiceRequestDto
{
    private int $limit;

    private int $offset;

    /** @var array<int> */
    private array $categories;

    /** @var array<string> */
    private array $tags;

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(array $data)
    {
        $this->limit = (int) ($data['limit'] ?? 10);
        $this->offset = (int) ($data['offset'] ?? 0);
        $this->categories = $data['categories'] ?? [];
        $this->tags = $data['tags'] ?? [];
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
     * @return array<string, int|string|array<int>|array<string>>
     */
    public function getQuery(): array
    {
        return [
            'limit' => $this->getLimit(),
            'offset' => $this->getOffset(),
            'categories' => $this->getCategories(),
            'tags' => $this->getTags(),
        ];
    }
}

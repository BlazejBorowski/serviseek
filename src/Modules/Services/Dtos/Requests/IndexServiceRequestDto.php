<?php

declare(strict_types=1);

namespace Modules\Services\Dtos\Requests;

class IndexServiceRequestDto
{
    private int $limit;

    private int $offset;

    private ?int $category;

    private ?string $tag;

    private ?string $filterValue;

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(array $data)
    {
        $this->limit = (int) ($data['limit'] ?? 10);
        $this->offset = (int) ($data['offset'] ?? 0);
        $this->category = (int) ($data['category'] ?? null);
        $this->tag = ($data['tag'] ?? null);
        $this->filterValue = ($data['filterValue'] ?? null);
    }

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

    public function getFilterValue(): ?string
    {
        return $this->filterValue ?? null;
    }
}

<?php

declare(strict_types=1);

namespace Modules\Services\Queries;

interface ServiceQueryInterface
{
    /**
     * @return array<string>
     */
    public function getColumns(): array;

    public function getFilterColumn(): string;

    public function getFilterValue(): ?string;

    /**
     * @return array<string>
     */
    public function getRelations(): array;

    public function getLimit(): int;

    public function getOffset(): int;

    public function getCategory(): ?int;

    public function getTag(): ?string;
}

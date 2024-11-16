<?php

declare(strict_types=1);

namespace Core\Helpers;

use Illuminate\Support\Collection;

class CollectionHelpers
{
    /**
     * @phpstan-ignore-next-line
     */
    public static function mapCollectionToIndexedArray(
        Collection $collection,
        callable $callback
    ): array {
        if ($collection->isEmpty()) {
            return [];
        }

        return $collection->map($callback)->values()->toArray();
    }
}

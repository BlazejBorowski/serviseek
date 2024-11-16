<?php

declare(strict_types=1);

namespace Modules\Services\Queries\ListServicesQuery;

use Illuminate\Support\Collection;
use Modules\Services\Repositories\ReadServiceRepository;
use Modules\Services\ValueObjects\Service as ValueObjectService;

class ListServicesQueryHandler
{
    public function __construct(
        private ReadServiceRepository $repository
    ) {}

    /**
     * @return Collection<int, ValueObjectService>
     */
    public function handle(ListServicesQuery $query): Collection
    {
        return $this->repository->getListing($query);
    }
}

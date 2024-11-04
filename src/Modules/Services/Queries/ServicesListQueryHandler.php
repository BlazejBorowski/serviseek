<?php

declare(strict_types=1);

namespace Modules\Services\Queries;

use Illuminate\Support\Collection;
use Modules\Services\Repositories\ReadServiceRepository;
use Modules\Services\ValueObjects\Service as ValueObjectService;

class ServicesListQueryHandler
{
    public function __construct(
        private ReadServiceRepository $repository
    ) {}

    /**
     * @return Collection<int, ValueObjectService>
     */
    public function handle(ServicesListQuery $query): Collection
    {
        return $this->repository->getListing($query);
    }
}

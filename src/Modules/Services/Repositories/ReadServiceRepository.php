<?php

declare(strict_types=1);

namespace Modules\Services\Repositories;

use Illuminate\Support\Collection;
use Modules\Services\Queries\ServicesListQuery;
use Modules\Services\ValueObjects\Service as ValueObjectService;

interface ReadServiceRepository
{
    /**
     * @return Collection<int, ValueObjectService>
     */
    public function getListing(ServicesListQuery $query): Collection;
}

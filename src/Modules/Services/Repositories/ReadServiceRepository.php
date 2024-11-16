<?php

declare(strict_types=1);

namespace Modules\Services\Repositories;

use Illuminate\Support\Collection;
use Modules\Services\Queries\GetServiceQuery\GetServiceQuery;
use Modules\Services\Queries\ListServicesQuery\ListServicesQuery;
use Modules\Services\ValueObjects\Service as ValueObjectService;

interface ReadServiceRepository
{
    /**
     * @return Collection<int, ValueObjectService>
     */
    public function getListing(ListServicesQuery $query): Collection;

    public function get(GetServiceQuery $query): ValueObjectService;
}

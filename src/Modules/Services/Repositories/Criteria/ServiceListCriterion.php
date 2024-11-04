<?php

declare(strict_types=1);

namespace Modules\Services\Repositories\Criteria;

use Modules\Services\Queries\ServicesListQuery;

interface ServiceListCriterion
{
    public function shouldApplyToList(ServicesListQuery $query): bool;
}

<?php

declare(strict_types=1);

namespace Modules\Services\Repositories\Criteria;

use Modules\Services\Queries\ServicesListQuery;

class ServiceCategoryCriterion implements ServiceListCriterion
{
    public function shouldApplyToList(ServicesListQuery $query): bool
    {
        return $query->getCategories() !== null;
    }
}

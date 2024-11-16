<?php

declare(strict_types=1);

namespace Modules\Services\Queries\GetServiceQuery;

use Modules\Services\Repositories\ReadServiceRepository;
use Modules\Services\ValueObjects\Service as ValueObjectService;

class GetServiceQueryHandler
{
    public function __construct(
        private ReadServiceRepository $repository
    ) {}

    public function handle(GetServiceQuery $query): ValueObjectService
    {
        return $this->repository->get($query);
    }
}

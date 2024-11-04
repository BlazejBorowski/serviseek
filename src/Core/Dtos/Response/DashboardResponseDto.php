<?php

declare(strict_types=1);

namespace Core\Dtos\Response;

use Illuminate\Support\Collection;
use Modules\Services\ValueObjects\Service;

class DashboardResponseDto
{
    /**
     * @param  Collection<int, Service>  $services
     */
    public function __construct(
        private Collection $services,
    ) {}

    /**
     * @return array<string, Collection<int, Service>>
     */
    public function getData(): array
    {
        return [
            'services' => $this->services,
        ];
    }
}

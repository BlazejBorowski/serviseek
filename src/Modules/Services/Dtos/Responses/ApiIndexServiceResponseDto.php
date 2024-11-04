<?php

declare(strict_types=1);

namespace Modules\Services\Dtos\Responses;

use Illuminate\Support\Collection;
use Modules\Services\ValueObjects\Service;

class ApiIndexServiceResponseDto
{
    /**
     * @param  Collection<int, Service>  $services
     */
    public function __construct(
        private Collection $services
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

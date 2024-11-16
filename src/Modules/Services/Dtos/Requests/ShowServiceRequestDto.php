<?php

declare(strict_types=1);

namespace Modules\Services\Dtos\Requests;

class ShowServiceRequestDto
{
    private string $serviceId;

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(array $data)
    {
        $this->serviceId = $data['service'];
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
    }
}

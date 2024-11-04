<?php

declare(strict_types=1);

namespace Modules\Services\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Services\ValueObjects\Service;

/**
 * @property array{services: \Illuminate\Support\Collection<int, Service>} $collection
 */
class ServiceCollection extends ResourceCollection
{
    /**
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection['services']->map(function (Service $service) {
                return [
                    'id' => $service->getId(),
                    'name' => $service->getName(),
                    'description' => $service->getDescription(),
                    'category' => $service->getCategory()->toArray(),
                    'main_email' => $service->getMainEmail()?->toArray(),
                    'main_phone' => $service->getMainPhone()?->toArray(),
                    'main_image' => $service->getMainImage()?->toArray(),
                    'created_at' => $service->getCreatedAt()->toDateTimeString(),
                    'updated_at' => $service->getUpdatedAt()->toDateTimeString(),
                    'deleted_at' => $service->getDeletedAt()?->toDateTimeString(),
                ];
            })->all(),
        ];
    }
}

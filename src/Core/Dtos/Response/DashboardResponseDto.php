<?php

declare(strict_types=1);

namespace Core\Dtos\Response;

use Core\Helpers\CollectionHelpers;
use Illuminate\Support\Collection;
use Modules\Services\ValueObjects\Service;
use Modules\Services\ValueObjects\ServiceTag;

class DashboardResponseDto
{
    /**
     * @param  Collection<int, Service>  $services
     */
    public function __construct(
        private Collection $services,
    ) {}

    /**
     * @return array<string, array<int, array{
     *      id: int,
     *      name: string,
     *      description: string|null,
     *      category: array{
     *          name: string
     *      }|null,
     *      main_email: array{
     *          email: array{
     *              value: string|null
     *          }|null
     *      }|null,
     *      main_phone: array{
     *          number: string|null
     *      }|null,
     *      tags: array<int, array{
     *          name: string
     *      }>,
     *      main_image: array{
     *          url: string|null
     *      }|null
     *  }>
     * >
     */
    public function getData(): array
    {
        return [
            'services' => CollectionHelpers::mapCollectionToIndexedArray(
                $this->getServices(),
                fn (Service $service) => [
                    'id' => $service->getId(),
                    'name' => $service->getName(),
                    'description' => $service->getDescription(),
                    'category' => [
                        'name' => $service->getCategoryName(),
                    ],
                    'main_email' => [
                        'email' => [
                            'value' => $service->getMainEmail()?->getEmailValue(),
                        ],
                    ],
                    'main_phone' => [
                        'number' => $service->getMainPhone()?->getNumber(),
                    ],
                    'tags' => CollectionHelpers::mapCollectionToIndexedArray(
                        $service->getTags(),
                        fn (ServiceTag $tag) => $tag->toArray()
                    ),
                    'main_image' => [
                        'url' => $service->getMainImage()?->getUrl(),
                    ],
                ]
            ),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }
}

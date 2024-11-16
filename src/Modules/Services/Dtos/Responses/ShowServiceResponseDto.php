<?php

declare(strict_types=1);

namespace Modules\Services\Dtos\Responses;

use Core\Helpers\CollectionHelpers;
use Modules\Services\ValueObjects\Service;
use Modules\Services\ValueObjects\ServiceEmail;
use Modules\Services\ValueObjects\ServiceImage;
use Modules\Services\ValueObjects\ServicePhone;
use Modules\Services\ValueObjects\ServiceTag;

class ShowServiceResponseDto
{
    public function __construct(
        private Service $service
    ) {}

    /**
     * @return array{
     *     service: array{
     *         name: string,
     *         description: string|null,
     *         category: array{
     *             name: string|null
     *         }|null,
     *         main_email: array{
     *             email: array{
     *                value: string|null
     *            }|null
     *         }|null,
     *         emails: array<int, array{
     *             email: array{
     *                 value: string|null
     *             }|null
     *         }|null>,
     *         main_phone: array{
     *             number: string|null
     *         }|null,
     *         phones: array<int, array{
     *             number: string|null
     *         }>|null,
     *         tags: array<int, array{
     *             name: string|null
     *         }>|null,
     *         main_image: array{
     *             url: string|null
     *         }|null,
     *         images: array<int, array{
     *             image: string|null
     *         }>|null
     *     }
     * }
     */
    public function getData(): array
    {
        return [
            'service' => [
                'name' => $this->getService()->getName(),
                'description' => $this->getService()->getDescription(),
                'category' => [
                    'name' => $this->getService()->getCategoryName(),
                ],
                'main_email' => [
                    'email' => [
                        'value' => $this->getService()->getMainEmail()?->getEmailValue(),
                    ],
                ],
                'emails' => CollectionHelpers::mapCollectionToIndexedArray(
                    $this->getService()->getSecondaryItems($this->getService()->getEmails()),
                    fn (ServiceEmail $email) => [
                        'email' => [
                            'value' => $email->getEmailValue(),
                        ],
                    ]
                ),
                'main_phone' => [
                    'number' => $this->getService()->getMainPhone()?->getNumber(),
                ],
                'phones' => CollectionHelpers::mapCollectionToIndexedArray(
                    $this->getService()->getSecondaryItems($this->getService()->getPhones()),
                    fn (ServicePhone $phone) => [
                        'number' => $phone->getNumber(),
                    ]
                ),
                'tags' => CollectionHelpers::mapCollectionToIndexedArray(
                    $this->getService()->getTags(),
                    fn (ServiceTag $tag) => [
                        'name' => $tag->getName(),
                    ]
                ),
                'main_image' => [
                    'url' => $this->getService()->getMainImage()?->getUrl(),
                ],
                'images' => CollectionHelpers::mapCollectionToIndexedArray(
                    $this->getService()->getSecondaryItems($this->getService()->getImages()),
                    fn (ServiceImage $image) => [
                        'image' => $image->getUrl(),
                    ]
                ),
            ],
        ];
    }

    public function getService(): Service
    {
        return $this->service;
    }
}

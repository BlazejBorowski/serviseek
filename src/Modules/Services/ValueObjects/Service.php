<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects;

use BlazejBorowski\LaravelValueObjects\ValueObject;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Modules\Services\ValueObjects\Interfaces\HasMainInterface;

/**
 * @phpstan-import-type ServiceEmailData from ServiceEmail
 * @phpstan-import-type ServicePhoneData from ServicePhone
 * @phpstan-import-type ServiceTagData from ServiceTag
 * @phpstan-import-type ServiceImageData from ServiceImage
 * @phpstan-import-type ServiceCategoryData from ServiceCategory
 *
 * @phpstan-type ServiceData array{
 *     id: int|null,
 *     name: string,
 *     description: string|null,
 *     category: ServiceCategoryData|null,
 *     main_email: ServiceEmailData|null,
 *     emails: ServiceEmailData[]|null,
 *     main_phone: ServicePhoneData|null,
 *     phones: ServicePhoneData[]|null,
 *     tags: ServiceTagData[]|null,
 *     main_image: ServiceImageData|null,
 *     images: ServiceImageData[]|null,
 *     created_at: \Carbon\CarbonInterface|string|null,
 *     updated_at: \Carbon\CarbonInterface|string|null,
 *     deleted_at?: \Carbon\CarbonInterface|string|null
 * }
 */
final readonly class Service extends ValueObject
{
    private readonly ?int $id;

    private readonly string $name;

    private readonly ?string $description;

    private readonly ?ServiceCategory $category;

    /** @var Collection<int, ServiceEmail> */
    private readonly ?Collection $emails;

    /** @var Collection<int, ServicePhone> */
    private readonly ?Collection $phones;

    /** @var Collection<int, ServiceTag> */
    private readonly ?Collection $tags;

    /** @var Collection<int, ServiceImage> */
    private readonly ?Collection $images;

    private readonly ?ServiceEmail $main_email;

    private readonly ?ServicePhone $main_phone;

    private readonly ?ServiceImage $main_image;

    private readonly ?CarbonInterface $created_at;

    private readonly ?CarbonInterface $updated_at;

    private readonly ?CarbonInterface $deleted_at;

    /**
     * @param  ServiceData  $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->description = $data['description'] ?? null;

        $this->category = isset($data['category']) ? new ServiceCategory($data['category']) : null;
        $this->emails = isset($data['emails']) ? collect($data['emails'])->map(fn ($email) => new ServiceEmail($email)) : null;
        $this->phones = isset($data['phones']) ? collect($data['phones'])->map(fn ($phone) => new ServicePhone($phone)) : null;
        $this->tags = isset($data['tags']) ? collect($data['tags'])->map(fn ($tag) => new ServiceTag($tag)) : null;
        $this->images = isset($data['images']) ? collect($data['images'])->map(fn ($image) => new ServiceImage($image)) : null;

        $this->main_email = $this->getMainItem($this->emails) ?? (isset($data['main_email']) ? new ServiceEmail($data['main_email']) : null);
        $this->main_phone = $this->getMainItem($this->phones) ?? (isset($data['main_phone']) ? new ServicePhone($data['main_phone']) : null);
        $this->main_image = $this->getMainItem($this->images) ?? (isset($data['main_image']) ? new ServiceImage($data['main_image']) : null);

        $this->created_at = isset($data['created_at']) ? Carbon::parse($data['created_at']) : null;
        $this->updated_at = isset($data['updated_at']) ? Carbon::parse($data['updated_at']) : null;
        $this->deleted_at = isset($data['deleted_at']) ? Carbon::parse($data['deleted_at']) : null;
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function getCategoryValueObject(): ?ServiceCategory
    {
        return $this->category ?? null;
    }

    public function getCategoryName(): ?string
    {
        return $this->category?->getName() ?? null;
    }

    /**
     * @return Collection<int, ServiceEmail>
     */
    public function getEmails(): Collection
    {
        return $this->emails ?? collect();
    }

    /**
     * @return ServiceEmail|null
     */
    public function getMainEmail(): ?object
    {
        return $this->main_email ?? null;
    }

    /**
     * @return Collection<int, ServicePhone>
     */
    public function getPhones(): Collection
    {
        return $this->phones ?? collect();
    }

    public function getMainPhone(): ?ServicePhone
    {
        return $this->main_phone ?? null;
    }

    /**
     * @return Collection<int, ServiceTag>
     */
    public function getTags(): Collection
    {
        return $this->tags ?? collect();
    }

    /**
     * @return Collection<int, ServiceImage>
     */
    public function getImages(): Collection
    {
        return $this->images ?? collect();
    }

    public function getMainImage(): ?ServiceImage
    {
        return $this->main_image ?? null;
    }

    public function getCreatedAt(): ?CarbonInterface
    {
        return $this->created_at ?? null;
    }

    public function getUpdatedAt(): ?CarbonInterface
    {
        return $this->updated_at ?? null;
    }

    public function getDeletedAt(): ?CarbonInterface
    {
        return $this->deleted_at ?? null;
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category?->toArray(),
            'emails' => $this->emails?->toArray(),
            'main_email' => $this->main_email?->toArray(),
            'phones' => $this->phones?->toArray(),
            'main_phone' => $this->main_phone?->toArray(),
            'tags' => $this->tags?->toArray(),
            'images' => $this->images?->toArray(),
            'main_image' => $this->main_image?->toArray(),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'deleted_at' => $this->deleted_at?->toDateTimeString(),
        ]);
    }

    public function __toString(): string
    {
        return sprintf(
            "Name: %s\nCategory: %s\nMain Email: %s\nMain Phone: %s\nDescription: %s",
            $this->getName(),
            $this->getCategoryName() ?? '',
            $this->getMainEmail()?->getEmailValue() ?? '',
            $this->getMainPhone()?->getNumber() ?? '',
            $this->getDescription() ?? '',
        );
    }

    /**
     * @param  ServiceData  $data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    /**
     * @template T of HasMainInterface
     *
     * @param  Collection<int, T>|null  $items
     * @return T|null
     */
    public function getMainItem(?Collection $items): ?HasMainInterface
    {
        if ($items === null) {
            return null;
        }

        return $items->first(fn (HasMainInterface $item) => $item->isMain() === true);
    }

    /**
     * @template T of HasMainInterface
     *
     * @param  Collection<int, T>|null  $items
     * @return Collection<int, T>
     */
    public function getSecondaryItems(?Collection $items): Collection
    {
        if ($items === null) {
            return collect();
        }

        return $items->filter(fn (HasMainInterface $item) => ! $item->isMain());
    }
}

<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects;

use BlazejBorowski\LaravelValueObjects\ValueObject;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

/**
 * @phpstan-import-type ServiceEmailData from ServiceEmail
 * @phpstan-import-type ServicePhoneData from ServicePhone
 * @phpstan-import-type ServiceTagData from ServiceTag
 * @phpstan-import-type ServiceImageData from ServiceImage
 * @phpstan-import-type ServiceCategoryData from ServiceCategory
 *
 * @phpstan-type ServiceData array{
 *     id: int,
 *     name: string,
 *     description: string,
 *     category: ServiceCategoryData,
 *     emails: ServiceEmailData[],
 *     phones: ServicePhoneData[],
 *     tags: ServiceTagData[],
 *     images: ServiceImageData[],
 *     created_at: \Carbon\CarbonInterface|string,
 *     updated_at: \Carbon\CarbonInterface|string,
 *     deleted_at?: \Carbon\CarbonInterface|string|null
 * }
 */
final readonly class Service extends ValueObject
{
    private readonly int $id;

    private readonly string $name;

    private readonly string $description;

    private readonly ServiceCategory $category;

    /** @var Collection<int, ServiceEmail> */
    private readonly Collection $emails;

    /** @var Collection<int, ServicePhone> */
    private readonly Collection $phones;

    /** @var Collection<int, ServiceTag> */
    private readonly Collection $tags;

    /** @var Collection<int, ServiceImage> */
    private readonly Collection $images;

    private readonly CarbonInterface $created_at;

    private readonly CarbonInterface $updated_at;

    private readonly ?CarbonInterface $deleted_at;

    /**
     * @param  ServiceData  $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->category = new ServiceCategory($data['category']);
        $this->emails = collect($data['emails'])->map(fn ($email) => new ServiceEmail($email));
        $this->phones = collect($data['phones'])->map(fn ($phone) => new ServicePhone($phone));
        $this->tags = collect($data['tags'])->map(fn ($tag) => new ServiceTag($tag));
        $this->images = collect($data['images'])->map(fn ($image) => new ServiceImage($image));
        $this->created_at = Carbon::parse($data['created_at']);
        $this->updated_at = Carbon::parse($data['updated_at']);
        $this->deleted_at = isset($data['deleted_at']) ? Carbon::parse($data['deleted_at']) : null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): ServiceCategory
    {
        return $this->category;
    }

    /**
     * @return Collection<int, ServiceEmail>
     */
    public function getEmails(): Collection
    {
        return $this->emails;
    }

    /**
     * @return ServiceEmail|null
     */
    public function getMainEmail(): ?object
    {
        return $this->getMainItem($this->emails);
    }

    /**
     * @return Collection<int, ServicePhone>
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function getMainPhone(): ?ServicePhone
    {
        return $this->getMainItem($this->phones);
    }

    /**
     * @return Collection<int, ServiceTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @return Collection<int, ServiceImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function getMainImage(): ?ServiceImage
    {
        return $this->getMainItem($this->images);
    }

    public function getCreatedAt(): CarbonInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): CarbonInterface
    {
        return $this->updated_at;
    }

    public function getDeletedAt(): ?CarbonInterface
    {
        return $this->deleted_at;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'category' => $this->getCategory()->toArray(),
            'main_email' => $this->getMainEmail()?->toArray(),
            'emails' => $this->getEmails()->toArray(),
            'main_phone' => $this->getMainPhone()?->toArray(),
            'phones' => $this->getPhones()->toArray(),
            'tags' => $this->getTags()->toArray(),
            'main_image' => $this->getMainImage()?->toArray(),
            'images' => $this->getImages()->toArray(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' => $this->getDeletedAt()?->toDateTimeString(),
        ];
    }

    public function __toString(): string
    {
        return sprintf(
            "Name: %s\nDescription: %s\nCategory: %s\nMain Email: %s\nMain Phone: %s",
            $this->name,
            $this->description,
            $this->category->getName(),
            $this->getMainEmail()?->getEmail() ?? 'N/A',
            $this->getMainPhone()?->getNumber() ?? 'N/A',
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
     * @template T of \Modules\Services\ValueObjects\Interfaces\HasMainInterface
     *
     * @param  Collection<int, T>  $items
     * @return T|null
     */
    private function getMainItem(Collection $items): ?object
    {
        foreach ($items as $item) {
            if ($item->isMain()) {
                return $item;
            }
        }

        return null;
    }
}

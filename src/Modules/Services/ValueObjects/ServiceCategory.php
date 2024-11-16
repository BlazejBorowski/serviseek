<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects;

use BlazejBorowski\LaravelValueObjects\ValueObject;
use BlazejBorowski\LaravelValueObjects\ValueObjectInterface;

/**
 * @phpstan-type ServiceCategoryData array{id: ?int, name: string}
 */
final readonly class ServiceCategory extends ValueObject
{
    private readonly ?int $id;

    private readonly string $name;

    /**
     * @param  ServiceCategoryData  $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId() ?? null,
            'name' => $this->name,
        ];
    }

    public function equals(ValueObjectInterface $object): bool
    {
        return $object instanceof self && $this->getName() === $object->getName();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @param  ServiceCategoryData  $data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}

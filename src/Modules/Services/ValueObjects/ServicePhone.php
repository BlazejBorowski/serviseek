<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects;

use BlazejBorowski\LaravelValueObjects\ValueObject;
use Modules\Services\ValueObjects\Interfaces\HasMainInterface;

/**
 * @phpstan-type ServicePhoneData array{service_id: int, number: string, description?: string, is_main: bool}
 */
final readonly class ServicePhone extends ValueObject implements HasMainInterface
{
    private readonly int $serviceId;

    private readonly string $number;

    private readonly string $description;

    private readonly bool $isMain;

    /**
     * @param  ServicePhoneData  $data
     */
    public function __construct(array $data)
    {
        $this->serviceId = $data['service_id'];
        $this->number = $data['number'];
        $this->description = $data['description'] ?? '';
        $this->isMain = $data['is_main'];
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isMain(): bool
    {
        return $this->isMain;
    }

    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'isMain' => $this->isMain,
        ];
    }

    /**
     * @param  ServicePhoneData  $data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}

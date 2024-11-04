<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects;

use BlazejBorowski\LaravelValueObjects\ValueObject;

/**
 * @phpstan-type ServiceTagData array{name: string}
 */
final readonly class ServiceTag extends ValueObject
{
    private string $name;

    /**
     * @param  ServiceTagData  $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    /**
     * @param  ServiceTagData  $data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}

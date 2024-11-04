<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects;

use BlazejBorowski\LaravelValueObjects\ValueObject;
use BlazejBorowski\LaravelValueObjects\ValueObjectInterface;
use Modules\Services\ValueObjects\Interfaces\HasMainInterface;

/**
 * @phpstan-type ServiceImageData array{url: string, is_main: bool}
 */
final readonly class ServiceImage extends ValueObject implements HasMainInterface
{
    private readonly string $url;

    private readonly bool $isMain;

    /**
     * @param  ServiceImageData  $data
     */
    public function __construct(array $data)
    {
        $this->url = $data['url'];
        $this->isMain = $data['is_main'];
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function isMain(): bool
    {
        return $this->isMain;
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'isMain' => $this->isMain,
        ];
    }

    public function equals(ValueObjectInterface $object): bool
    {
        return $object instanceof self && $this->url === $object->getUrl();
    }

    /**
     * @param  ServiceImageData  $data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}

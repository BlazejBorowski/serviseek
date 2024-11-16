<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects;

use BlazejBorowski\LaravelValueObjects\ValueObject;
use BlazejBorowski\LaravelValueObjects\ValueObjectInterface;
use BlazejBorowski\LaravelValueObjects\Values\Email;
use Modules\Services\ValueObjects\Interfaces\HasMainInterface;

/**
 * @phpstan-import-type EmailData from \BlazejBorowski\LaravelValueObjects\Values\Email
 *
 * @phpstan-type ServiceEmailData array{
 *  service_id: ?int,
 *  email: string,
 *  description?: string,
 *  is_main: ?bool
 * }
 */
final readonly class ServiceEmail extends ValueObject implements HasMainInterface
{
    private readonly ?int $service_id;

    private readonly Email $email;

    private readonly ?string $description;

    private readonly ?bool $is_main;

    /**
     * @param  ServiceEmailData  $data
     */
    public function __construct(array $data)
    {
        $this->service_id = $data['service_id'] ?? null;
        $this->email = new Email($data['email']);
        $this->description = $data['description'] ?? null;
        $this->is_main = $data['is_main'] ?? null;
    }

    public function getServiceId(): ?int
    {
        return $this->service_id ?? null;
    }

    public function getEmailValue(): string
    {
        return $this->email->getValue();
    }

    public function getEmailValueObject(): Email
    {
        return $this->email;
    }

    public function getEmailDomain(): string
    {
        return $this->email->getDomain();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isMain(): ?bool
    {
        return $this->is_main ?? null;
    }

    public function toArray(): array
    {
        return [
            'service_id' => $this->service_id,
            'email' => $this->email->toArray(),
            'description' => $this->description,
            'is_main' => $this->is_main,
        ];
    }

    public function equals(ValueObjectInterface $object): bool
    {
        return $object instanceof self && $this->getEmailValue() === $object->getEmailValue();
    }

    /**
     * @param  ServiceEmailData  $data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}

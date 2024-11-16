<?php

declare(strict_types=1);

namespace BlazejBorowski\LaravelValueObjects\Values;

use BlazejBorowski\LaravelValueObjects\ValueObject;
use BlazejBorowski\LaravelValueObjects\ValueObjectInterface;

/**
 * @phpstan-type EmailData email: string
 */
final readonly class Email extends ValueObject
{
    public function __construct(
        private string $value
    ) {}

    public function getValue(): string
    {
        return $this->value;
    }

    public function getDomain(): string
    {
        return substr(strrchr($this->value, '@'), 1);
    }

    public function getLocalPart(): string
    {
        return strstr($this->value, '@', true);
    }

    public function obfuscate(): string
    {
        [$localPart, $domain] = explode('@', $this->value);

        return substr($localPart, 0, 2).str_repeat('*', max(strlen($localPart) - 4, 0)).substr($localPart, -2).'@'.$domain;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
        ];
    }

    public function equals(ValueObjectInterface $object): bool
    {
        return $object instanceof self && $this->value === $object->getValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['email']);
    }
}

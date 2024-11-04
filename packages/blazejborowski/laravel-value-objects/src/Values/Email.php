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
        private string $email
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDomain(): string
    {
        return substr(strrchr($this->email, '@'), 1);
    }

    public function getLocalPart(): string
    {
        return strstr($this->email, '@', true);
    }

    public function obfuscate(): string
    {
        [$localPart, $domain] = explode('@', $this->email);

        return substr($localPart, 0, 2).str_repeat('*', max(strlen($localPart) - 4, 0)).substr($localPart, -2).'@'.$domain;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
        ];
    }

    public function equals(ValueObjectInterface $object): bool
    {
        return $object instanceof self && $this->email === $object->getEmail();
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['email']);
    }
}

<?php

namespace BlazejBorowski\LaravelValueObjects;

abstract readonly class ValueObject implements ValueObjectInterface
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function equals(ValueObjectInterface $object): bool
    {
        return $object instanceof static && $this->serialize() === $object->serialize();
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    public function serialize(): string
    {
        return json_encode($this->toArray());
    }

    public static function deserialize(string $data): static
    {
        $decodedData = json_decode($data, true);

        return static::fromArray($decodedData);
    }

    public function copyWith(array $data): static
    {
        $newData = array_merge($this->toArray(), $data);

        return static::fromArray($newData);
    }

    abstract public static function fromArray(array $data): self;
}

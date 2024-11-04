<?php

declare(strict_types=1);

namespace BlazejBorowski\LaravelValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

interface ValueObjectInterface extends Arrayable, JsonSerializable
{
    public function toArray(): array;

    public function jsonSerialize(): array;

    public function equals(ValueObjectInterface $object): bool;

    public function __toString(): string;

    public function serialize(): string;

    public static function deserialize(string $data): self;

    public function copyWith(array $data): self;
}

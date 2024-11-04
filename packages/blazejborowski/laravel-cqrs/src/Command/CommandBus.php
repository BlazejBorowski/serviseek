<?php

declare(strict_types=1);

namespace BlazejBorowski\LaravelCqrs\Command;

interface CommandBus
{
    public function dispatch(Command $command): mixed;

    /**
     * @param  array<string, string>  $map
     */
    public function register(array $map): void;
}

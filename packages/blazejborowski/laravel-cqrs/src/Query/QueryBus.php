<?php

declare(strict_types=1);

namespace BlazejBorowski\LaravelCqrs\Query;

interface QueryBus
{
    public function ask(Query $query): mixed;

    /**
     * @param  array<string, string>  $map
     */
    public function register(array $map): void;
}

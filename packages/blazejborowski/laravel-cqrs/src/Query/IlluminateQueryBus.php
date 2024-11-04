<?php

declare(strict_types=1);

namespace BlazejBorowski\LaravelCqrs\Query;

use Illuminate\Bus\Dispatcher;

class IlluminateQueryBus implements QueryBus
{
    public function __construct(
        protected Dispatcher $bus,
    ) {}

    public function ask(Query $query): mixed
    {
        return $this->bus->dispatch($query);
    }

    /**
     * @param  array<string, string>  $map
     */
    public function register(array $map): void
    {
        $this->bus->map($map);
    }
}

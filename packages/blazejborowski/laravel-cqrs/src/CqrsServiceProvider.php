<?php

declare(strict_types=1);

namespace BlazejBorowski\LaravelCqrs;

use BlazejBorowski\LaravelCqrs\Command\CommandBus;
use BlazejBorowski\LaravelCqrs\Command\IlluminateCommandBus;
use BlazejBorowski\LaravelCqrs\Query\IlluminateQueryBus;
use BlazejBorowski\LaravelCqrs\Query\QueryBus;
use Illuminate\Support\ServiceProvider;

class CqrsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            CommandBus::class,
            IlluminateCommandBus::class,
        );

        $this->app->singleton(
            QueryBus::class,
            IlluminateQueryBus::class,
        );
    }

    public function boot(): void {}
}

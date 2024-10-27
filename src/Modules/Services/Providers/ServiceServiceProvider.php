<?php

declare(strict_types=1);

namespace Modules\Services\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Services\Actions\AddRandomServices\AddRandomServiceBasic;
use Modules\Services\Actions\AddRandomServices;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AddRandomServices::class, AddRandomServiceBasic::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__.'/../Database/Factories');
    }
}

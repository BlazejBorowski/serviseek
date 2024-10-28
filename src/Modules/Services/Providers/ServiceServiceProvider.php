<?php

declare(strict_types=1);

namespace Modules\Services\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Services\Actions\AddRandomServices;
use Modules\Services\Actions\AddRandomServices\AddRandomServiceBasic;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AddRandomServices::class, AddRandomServiceBasic::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}

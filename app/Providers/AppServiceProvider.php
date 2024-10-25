<?php

declare(strict_types=1);

namespace App\Providers;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        DB::prohibitDestructiveCommands($this->app->isProduction());

        Model::preventLazyLoading(! $this->app->isProduction());

        // Model::unguard(!$this->app->isProduction());

        DB::listen(function (QueryExecuted $event) {
            if ($event->time > 200) {
                Log::info('Long running query ('.$event->time.'ms): '.$event->sql);
            }
        });
    }
}

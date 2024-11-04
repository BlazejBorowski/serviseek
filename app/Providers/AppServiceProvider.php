<?php

declare(strict_types=1);

namespace App\Providers;

use DB;
use Illuminate\Database\Connection;
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

        Model::shouldBeStrict(! $this->app->isProduction());

        if (! $this->app->isProduction()) {
            // DB::listen(function (QueryExecuted $event) {

            // });

            DB::whenQueryingForLongerThan(200, function (Connection $connection, QueryExecuted $event) {
                Log::info('Long running query ('.$event->time.'ms): '.$event->sql);
            });
        }

    }
}

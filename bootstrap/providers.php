<?php

return [
    App\Providers\AppServiceProvider::class,
    \Matchish\ScoutElasticSearch\ElasticSearchServiceProvider::class,
    Modules\Services\Providers\ServiceServiceProvider::class,
];

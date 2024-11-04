<?php

return [
    App\Providers\AppServiceProvider::class,
    \Matchish\ScoutElasticSearch\ElasticSearchServiceProvider::class,
    Core\CoreServiceProvider::class,
    Modules\Services\ServicesServiceProvider::class,
];

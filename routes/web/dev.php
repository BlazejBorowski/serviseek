<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\Actions\AddRandomServices;

Route::get('/services/add-random', function (AddRandomServices $addRandomServices) {
    $service = $addRandomServices->handle();

    return 'Service added: '.$service->name;
})->name('services.add-random');

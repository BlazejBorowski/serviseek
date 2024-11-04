<?php

use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;
use Modules\Services\Features\Api\ServicesApiIndexFeature;
use Modules\Services\Http\Controllers\ApiServiceController;

Route::get('/services', [ApiServiceController::class, 'index'])->name('services.index')->middleware(EnsureFeaturesAreActive::using(ServicesApiIndexFeature::class));

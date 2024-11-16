<?php

use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;
use Modules\Services\Features\ServiceWebListFeature;
use Modules\Services\Features\ServiceWebManagementFeature;
use Modules\Services\Features\ServiceWebShowFeature;
use Modules\Services\Http\Controllers\ServiceController;

Route::middleware([
    'auth',
    EnsureFeaturesAreActive::using(ServiceWebManagementFeature::class),
])->group(function () {
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
});

Route::get('/services', [ServiceController::class, 'index'])->name('services.index')->middleware(EnsureFeaturesAreActive::using(ServiceWebListFeature::class));
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show')->middleware(EnsureFeaturesAreActive::using(ServiceWebShowFeature::class));

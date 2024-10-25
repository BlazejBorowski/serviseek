<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\Http\Controllers\ServiceController;
use Modules\Services\Http\Controllers\ServiceTestController;

Route::get('/services/add-random', [ServiceTestController::class, 'addRandomService']);
Route::get('/services/test', [ServiceTestController::class, 'test']);
Route::resource('services', ServiceController::class);

<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\Http\Controllers\ServiceController;

Route::resource('services', ServiceController::class);

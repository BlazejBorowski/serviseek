<?php

use Core\Http\Controllers\CoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CoreController::class, 'dashboard'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
require __DIR__.'/dev.php';
require __DIR__.'/services.php';

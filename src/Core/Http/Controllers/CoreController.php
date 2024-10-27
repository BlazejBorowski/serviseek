<?php

declare(strict_types=1);

namespace Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Inertia\Inertia;
use Modules\Services\Models\Service;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    public function dashboard(Request $request)
    {
        $services = Service::paginate(10);

        if (Auth::check()) {
            return Inertia::render('Dashboard', [
                'services' => $services,
            ]);
        } else {
            return Inertia::render('Welcome', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'laravelVersion' => Application::VERSION,
                'phpVersion' => PHP_VERSION,
                'services' => $services,
            ]);
        }
    }
}

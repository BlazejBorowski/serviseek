<?php

declare(strict_types=1);

namespace Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Services\Models\Service;

class CoreController extends Controller
{
    public function dashboard(Request $request): Response
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

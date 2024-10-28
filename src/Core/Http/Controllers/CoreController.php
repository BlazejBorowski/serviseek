<?php

declare(strict_types=1);

namespace Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Services\Models\Service;

class CoreController extends Controller
{
    public function dashboard(Request $request): Response
    {
        $services = Service::paginate(10);

        return Inertia::render('Dashboard', [
            'services' => $services,
        ]);
    }
}

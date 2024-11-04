<?php

declare(strict_types=1);

namespace Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Services\Http\Requests\StoreServiceRequest;
use Modules\Services\Http\Requests\UpdateServiceRequest;
use Modules\Services\Models\Service;
use Nette\NotImplementedException;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $services = Service::paginate(20);

        return Inertia::render('Services/List', [
            'services' => $services,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): never
    {
        throw new NotImplementedException;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): never
    {
        throw new NotImplementedException;
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): Response
    {
        return Inertia::render('Services/Show', [
            'service' => $service,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): never
    {
        throw new NotImplementedException;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service): never
    {
        throw new NotImplementedException;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): never
    {
        throw new NotImplementedException;
    }
}

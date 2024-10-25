<?php

namespace Modules\Services\Http\Controllers;

use App\Exceptions\UserException;
use App\Http\Controllers\Controller;
use Modules\Services\Models\Service;

class ServiceTestController extends Controller
{
    public function addRandomService()
    {
        $service = Service::create([
            'name' => 'Random Service '.rand(1, 1000),
            'description' => 'This is a randomly generated service.',
            'contact' => 'contact@example.com',
            'address' => 'Random Address',
            'service_type' => 'Random Type',
        ]);

        return redirect()->route('services.index')->with('success', 'Random service added!');
    }

    public function test()
    {
        return 'Test';
    }

    public function throwMissingUser()
    {
        throw UserException::missingAuthenticatedUser();
    }
}

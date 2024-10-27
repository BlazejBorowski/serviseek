<?php

declare(strict_types=1);

namespace Modules\Services\Actions\AddRandomServices;

use Modules\Services\Actions\AddRandomServices;
use Modules\Services\Models\Service;

class AddRandomServiceBasic implements AddRandomServices
{
    public function handle(): Service
    {
        $service = Service::create([
            'name' => 'Random Service '.random_int(1, 1000),
            'description' => 'This is a randomly generated service.',
        ]);

        return $service;
    }
}

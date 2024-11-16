<?php

namespace Tests\Feature\Service\WebRoute;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Modules\Services\Models\Service;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class ServiceRouteIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_inertia_response_with_services(): void
    {
        $user = UserHelper::createAdminUser();
        Service::factory()->count(25)->create();

        $this->actingAs($user);

        $response = $this->get(route('services.index'));

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->has('services', 20)
        );
    }
}

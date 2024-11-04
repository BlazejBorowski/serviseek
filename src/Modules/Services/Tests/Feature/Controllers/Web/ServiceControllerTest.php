<?php

declare(strict_types=1);

namespace Modules\Services\Tests\Feature\Controllers\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Modules\Services\Models\Service;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_inertia_response_with_services(): void
    {
        $user = UserHelper::createAdminUser();
        Service::factory()->count(25)->create();

        $this->actingAs($user);

        $response = $this->get(route('services.index'));

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->has('services.data', 20)
        );
    }
}

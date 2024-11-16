<?php

declare(strict_types=1);

namespace Tests\Feature\Service\WebRoute;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Testing\TestResponse;
use Modules\Services\Models\Service;
use Tests\TestCase;

// use IlluminateFoundationTestingRefreshDatabase;

class ServiceRouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string[]
     */
    private array $notImplementedRoutes = [
        'services.create',
        'services.store',
        'services.edit',
        'services.update',
        'services.destroy',
    ];

    /**
     * @var string[]
     */
    private array $guestRoutes = [
        'dashboard',
    ];

    /**
     * @var string[]
     */
    private array $authRoutes = [

    ];

    /**
     * @var string[]
     */
    private array $adminRoutes = [
        'services.index',
        'services.show',
        'services.create',
        'services.store',
        'services.edit',
        'services.update',
        'services.destroy',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DevSeeder']);
    }

    /**
     * @return TestResponse<\Illuminate\Http\Response>
     */
    private function makeRequest(string $route, ?Service $service = null): TestResponse
    {
        return match ($route) {
            'services.store' => $this->post(route($route), []),
            'services.update' => $this->put(route($route, $service), []),
            'services.destroy' => $this->delete(route($route, $service)),
            default => $this->get(route($route, $service)),
        };
    }

    public function test_guest_cannot_access_protected_routes(): void
    {
        if (empty($this->authRoutes)) {
            $this->markTestSkipped('No protected routes found');
        }
        foreach ($this->authRoutes as $route) {
            $service = Service::factory()->create();
            $response = $this->makeRequest($route, $service);

            $response->assertRedirect(route('login'));
        }
    }

    public function test_guest_can_access_public_routes(): void
    {
        if (empty($this->guestRoutes)) {
            $this->markTestSkipped('No public routes found');
        }
        foreach ($this->guestRoutes as $route) {
            $service = Service::factory()->create();
            $response = $this->makeRequest($route, $service);

            $response->assertStatus(200);
        }
    }

    public function test_authenticated_user_can_access_all_routes(): void
    {
        if (empty($this->authRoutes) && empty($this->adminRoutes)) {
            $this->markTestSkipped('No protected routes found');
        }
        $user = User::factory()->create();
        $this->actingAs($user);

        $allRoutes = array_merge($this->guestRoutes, $this->authRoutes);

        foreach ($allRoutes as $route) {
            $service = Service::factory()->create();
            $isNotImplemented = in_array($route, $this->notImplementedRoutes);

            $response = $this->makeRequest($route, $service);

            $isNotImplemented ? $response->assertStatus(501) : $response->assertStatus(200);
        }
    }

    public function test_not_implemented_routes_shows_not_found_for_authenticated_user(): void
    {
        if (empty($this->notImplementedRoutes)) {
            $this->markTestSkipped('No not implemented routes found');
        }
        $user = User::factory()->create();
        $this->actingAs($user);

        foreach ($this->notImplementedRoutes as $route) {
            Exceptions::fake();
            $service = Service::factory()->create();

            $response = $this->makeRequest($route, $service);

            $response->assertStatus(404);

            $response->assertSeeText('Not Found');
        }
    }
}

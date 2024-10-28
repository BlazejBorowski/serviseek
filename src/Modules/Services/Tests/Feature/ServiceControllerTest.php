<?php

declare(strict_types=1);

namespace Modules\Services\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Testing\TestResponse;
use Modules\Services\Models\Service;
use Nette\NotImplementedException;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string[]
     */
    private array $notImplementedMethods = [
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
        'services.index',
        'services.show',
    ];

    /**
     * @var string[]
     */
    private array $authRoutes = [
        'services.create',
        'services.store',
        'services.edit',
        'services.update',
        'services.destroy',
    ];

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
        foreach ($this->authRoutes as $route) {
            $service = Service::factory()->create();
            $response = $this->makeRequest($route, $service);

            $response->assertRedirect(route('login'));
        }
    }

    public function test_guest_can_access_public_routes(): void
    {
        foreach ($this->guestRoutes as $route) {
            $service = Service::factory()->create();
            $response = $this->makeRequest($route, $service);

            $response->assertStatus(200);
        }
    }

    public function test_authenticated_user_can_access_all_routes(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $allRoutes = array_merge($this->guestRoutes, $this->authRoutes);

        foreach ($allRoutes as $route) {
            $service = Service::factory()->create();
            $isNotImplemented = in_array($route, $this->notImplementedMethods);

            $response = $this->makeRequest($route, $service);

            $isNotImplemented ? $response->assertStatus(501) : $response->assertStatus(200);
        }
    }

    public function test_not_implemented_methods_throw_exception_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        foreach ($this->notImplementedMethods as $route) {
            Exceptions::fake();
            $service = Service::factory()->create();

            $response = $this->makeRequest($route, $service);

            Exceptions::assertReported(NotImplementedException::class);
            $response->assertStatus(501);
        }
    }
}

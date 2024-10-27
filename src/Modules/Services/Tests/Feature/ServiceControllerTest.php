<?php

declare(strict_types=1);

namespace Modules\Services\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Exceptions;
use Nette\NotImplementedException;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_throws_not_implemented_exception(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        Exceptions::fake();

        $response = $this->actingAs($user)
            ->get('/services/create');

        Exceptions::assertReported(NotImplementedException::class);

        $response->assertStatus(501);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Service\ApiRoute;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Services\Models\Service;
use Modules\Services\Models\ServiceCategory;
use Tests\TestCase;

class ServiceApiRouteListTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'DevSeeder']);
    }

    public function test_it_applies_limit_correctly()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->getJson('/api/services?limit=5');

        $response->assertStatus(200);
        $this->assertCount(5, $response->json('data'));
    }

    public function test_it_applies_offset_correctly()
    {
        $user = User::first();
        $this->actingAs($user);

        $responseFirst = $this->getJson('/api/services?limit=5&offset=0');
        $firstItem = $responseFirst->json('data')[0]['id'];

        $responseOffset = $this->getJson('/api/services?limit=5&offset=5');
        $offsetItem = $responseOffset->json('data')[0]['id'];

        $this->assertNotEquals($firstItem, $offsetItem);
    }

    public function test_it_filters_by_category()
    {
        $user = User::first();
        $this->actingAs($user);

        $category1 = ServiceCategory::first();
        $category2 = ServiceCategory::skip(1)->first();
        $service1 = Service::where('category_id', $category1->id)->first();
        $service2 = Service::where('category_id', $category2->id)->first();

        $response = $this->getJson('/api/services?category='.$category1->id);

        $response->assertStatus(200);

        $this->assertContains($service1->id, array_column($response->json('data'), 'id'));
        $this->assertNotContains($service2->id, array_column($response->json('data'), 'id'));
    }

    public function test_it_filters_by_tag()
    {
        $user = User::first();
        $this->actingAs($user);

        $service1 = Service::with('tags')->first();
        $tag1 = $service1->tags->first();
        $service2 = Service::whereDoesntHave('tags', function ($query) use ($tag1) {
            $query->where('name', $tag1->name);
        })->first();

        $response = $this->getJson('/api/services?limit=100&tag='.$tag1->name);

        $response->assertStatus(200);

        $this->assertContains($service1->id, array_column($response->json('data'), 'id'));

        if ($service2) {
            $this->assertNotContains($service2->id, array_column($response->json('data'), 'id'));
        }
    }
}

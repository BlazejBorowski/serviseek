<?php

declare(strict_types=1);

namespace Modules\Services\Tests\Feature\Controllers\Api;

use BlazejBorowski\LaravelCqrs\Query\QueryBus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Modules\Services\Http\Controllers\ApiServiceController;
use Modules\Services\Http\Requests\ApiIndexServiceRequest;
use Modules\Services\Http\Resources\ServiceCollection;
use Tests\TestCase;

class ApiServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_valid_response(): void
    {
        $this->artisan('db:seed', ['--class' => 'DevSeeder']);

        $queryBus = app(QueryBus::class);

        $request = Request::create(
            uri: '',
            method: 'GET',
            parameters: [
                'limit' => 1,
                'offset' => 0,
                'categories' => [],
                'tags' => [],
            ]
        );

        $formRequest = ApiIndexServiceRequest::createFrom($request);
        $formRequest->setContainer(app());
        $formRequest->validateResolved();

        $controller = new ApiServiceController($queryBus);

        $response = $controller->index($formRequest);

        $this->assertInstanceOf(ServiceCollection::class, $response);

        $responseData = $response->toArray($request);

        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);

        $firstItem = $responseData['data'][0];

        $this->assertArrayHasKey('id', $firstItem);
        $this->assertIsInt($firstItem['id']);

        $this->assertArrayHasKey('name', $firstItem);
        $this->assertIsString($firstItem['name']);

        $this->assertArrayHasKey('description', $firstItem);
        $this->assertIsString($firstItem['description']);

        $this->assertArrayHasKey('category', $firstItem);
        $this->assertIsArray($firstItem['category']);
        $this->assertArrayHasKey('id', $firstItem['category']);
        $this->assertIsInt($firstItem['category']['id']);
        $this->assertArrayHasKey('name', $firstItem['category']);
        $this->assertIsString($firstItem['category']['name']);

        $this->assertArrayHasKey('main_email', $firstItem);
        $this->assertIsArray($firstItem['main_email']);
        $this->assertArrayHasKey('service_id', $firstItem['main_email']);
        $this->assertIsInt($firstItem['main_email']['service_id']);
        $this->assertArrayHasKey('email', $firstItem['main_email']);
        $this->assertIsArray($firstItem['main_email']['email']);
        $this->assertArrayHasKey('email', $firstItem['main_email']['email']);
        $this->assertIsString($firstItem['main_email']['email']['email']);
        $this->assertTrue($firstItem['main_email']['is_main']);

        $this->assertArrayHasKey('main_phone', $firstItem);
        $this->assertIsArray($firstItem['main_phone']);
        $this->assertArrayHasKey('number', $firstItem['main_phone']);
        $this->assertIsString($firstItem['main_phone']['number']);
        $this->assertTrue($firstItem['main_phone']['isMain']);

        $this->assertArrayHasKey('main_image', $firstItem);
        $this->assertIsArray($firstItem['main_image']);
        $this->assertArrayHasKey('url', $firstItem['main_image']);
        $this->assertIsString($firstItem['main_image']['url']);
        $this->assertTrue($firstItem['main_image']['isMain']);

        $this->assertArrayHasKey('created_at', $firstItem);
        $this->assertIsString($firstItem['created_at']);

        $this->assertArrayHasKey('updated_at', $firstItem);
        $this->assertIsString($firstItem['updated_at']);

        $this->assertArrayHasKey('deleted_at', $firstItem);
        $this->assertNull($firstItem['deleted_at']);
    }

    // public function test_it_applies_limit_correctly()
    // {
    //     $response = $this->getJson('/api/services?limit=5');

    //     $response->assertStatus(200);
    //     $this->assertCount(5, $response->json('data'));
    // }

    // public function test_it_applies_offset_correctly()
    // {
    //     $responseFirst = $this->getJson('/api/services?limit=5&offset=0');
    //     $firstItem = $responseFirst->json('data')[0]['id'];

    //     $responseOffset = $this->getJson('/api/services?limit=5&offset=5');
    //     $offsetItem = $responseOffset->json('data')[0]['id'];

    //     $this->assertNotEquals($firstItem, $offsetItem);
    // }

    // public function test_it_filters_by_category()
    // {
    //     $category = ServiceCategory::first();
    //     $service = Service::factory()->create(['category_id' => $category->id]);

    //     $response = $this->getJson('/api/services?categories[]=' . $category->id);

    //     $response->assertStatus(200);
    //     $this->assertEquals($service->id, $response->json('data')[0]['id']);
    // }

    // public function test_it_filters_by_tag()
    // {
    //     $tag = ServiceTag::first();
    //     $service = Service::factory()->create();
    //     $service->tags()->attach($tag);

    //     $response = $this->getJson('/api/services?tags[]=' . $tag->id);

    //     $response->assertStatus(200);
    //     $response->assertJsonFragment(['id' => $service->id]);
    // }
}

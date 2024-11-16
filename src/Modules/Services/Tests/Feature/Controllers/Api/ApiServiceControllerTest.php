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

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'DevSeeder']);
    }

    public function test_index_returns_valid_response(): void
    {
        $queryBus = app(QueryBus::class);

        $request = Request::create(
            uri: '',
            method: 'GET',
            parameters: [
                'limit' => 1,
                'offset' => 0,
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
        $this->assertArrayHasKey('value', $firstItem['main_email']['email']);
        $this->assertIsString($firstItem['main_email']['email']['value']);
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
    }
}

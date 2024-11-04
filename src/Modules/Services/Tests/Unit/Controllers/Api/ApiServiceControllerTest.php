<?php

declare(strict_types=1);

namespace Modules\Services\Tests\Unit\Controllers\Api;

use BlazejBorowski\LaravelCqrs\Query\QueryBus;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Modules\Services\Http\Controllers\ApiServiceController;
use Modules\Services\Http\Requests\ApiIndexServiceRequest;
use Modules\Services\Http\Resources\ServiceCollection;
use Modules\Services\ValueObjects\Service as ValueObjectService;
use Tests\TestCase;

class ApiServiceControllerTest extends TestCase
{
    public function test_it_returns_json_data_in_service_collection(): void
    {
        $queryBus = $this->mock(QueryBus::class, function (MockInterface $mock) {
            $mock->shouldReceive('ask')
                ->once()
                ->andReturn(collect([
                    new ValueObjectService([
                        'id' => 1,
                        'name' => 'Example Service',
                        'description' => 'Example description',
                        'category' => [
                            'id' => 1,
                            'name' => 'Example Category',
                        ],
                        'emails' => [
                            [
                                'service_id' => 1,
                                'email' => 'example@example.com',
                                'description' => 'Example email',
                                'is_main' => true,
                            ],
                        ],
                        'phones' => [
                            [
                                'service_id' => 1,
                                'number' => '123-456-789',
                                'is_main' => true,
                            ],
                        ],
                        'images' => [
                            [
                                'url' => 'https://example.com/image.jpg',
                                'is_main' => true,
                            ],
                        ],
                        'tags' => [
                            [
                                'name' => 'exampleTag',
                            ],
                        ],
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                        'deleted_at' => null,
                    ]),
                ]));
        });

        $request = Request::create(
            uri: '',
            method: 'GET',
            parameters: [
                'limit' => 10,
                'offset' => 0,
                'categories' => [],
                'tags' => [],
            ]
        );

        $formRequest = ApiIndexServiceRequest::createFrom($request);
        $formRequest->setContainer(app());
        $formRequest->validateResolved();

        /** @var QueryBus $queryBus */
        $controller = new ApiServiceController($queryBus);

        $response = $controller->index($formRequest);

        $this->assertInstanceOf(ServiceCollection::class, $response);

        $responseData = $response->toArray($request);

        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);

        $firstItem = $responseData['data'][0];

        $this->assertEquals(1, $firstItem['id']);
        $this->assertEquals('Example Service', $firstItem['name']);
        $this->assertEquals('Example description', $firstItem['description']);
        $this->assertArrayHasKey('category', $firstItem);
        $this->assertEquals(1, $firstItem['category']['id']);
        $this->assertEquals('Example Category', $firstItem['category']['name']);

        $this->assertArrayHasKey('main_email', $firstItem);
        $this->assertEquals('example@example.com', $firstItem['main_email']['email']['email']);
        $this->assertTrue($firstItem['main_email']['is_main']);

        $this->assertArrayHasKey('main_phone', $firstItem);
        $this->assertEquals('123-456-789', $firstItem['main_phone']['number']);
        $this->assertTrue($firstItem['main_phone']['isMain']);

        $this->assertArrayHasKey('main_image', $firstItem);
        $this->assertEquals('https://example.com/image.jpg', $firstItem['main_image']['url']);
        $this->assertTrue($firstItem['main_image']['isMain']);

        $this->assertArrayHasKey('created_at', $firstItem);
        $this->assertArrayHasKey('updated_at', $firstItem);
        $this->assertArrayHasKey('deleted_at', $firstItem);
        $this->assertNull($firstItem['deleted_at']);
    }
}

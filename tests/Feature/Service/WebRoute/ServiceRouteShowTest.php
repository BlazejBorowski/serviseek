<?php

namespace Tests\Feature\Service\WebRoute;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Modules\Services\Models\Service;
use Tests\TestCase;

class ServiceRouteShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_viable_service(): void
    {
        $this->artisan('db:seed', ['--class' => 'DevSeeder']);
        $service = Service::with('category', 'emails', 'phones', 'tags', 'images')->first()->toValueObject();

        $response = $this->get(route('services.show', ['service' => $service->getId()]))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('service', fn (AssertableInertia $page) => $page
                    ->where('name', $service->getName())
                    ->where('description', $service->getDescription())
                    ->has('category', fn (AssertableInertia $category) => $category
                        ->has('name')
                    )
                    ->has('main_email', fn (AssertableInertia $mainEmail) => $mainEmail
                        ->has('email', fn (AssertableInertia $emailValue) => $emailValue->has('value')
                        )
                    )
                    ->has('emails', fn (AssertableInertia $emails) => $emails->each(fn (AssertableInertia $emailItem) => $emailItem->has('email', fn (AssertableInertia $emailValue) => $emailValue->has('value')
                    )
                    )
                    )
                    ->has('main_phone', fn (AssertableInertia $mainPhone) => $mainPhone
                        ->has('number')
                    )
                    ->has('phones', fn (AssertableInertia $phones) => $phones->each(fn (AssertableInertia $phone) => $phone->has('number')
                    )
                    )
                    ->has('tags', fn (AssertableInertia $tags) => $tags
                        ->each(fn (AssertableInertia $tag) => $tag
                            ->has('name')
                        )
                    )
                    ->has('main_image', fn (AssertableInertia $mainImage) => $mainImage
                        ->has('url')
                    )
                    ->has('images', fn (AssertableInertia $images) => $images
                        ->each(fn (AssertableInertia $image) => $image
                            ->has('image')
                        )
                    )
                )
            );
    }
}

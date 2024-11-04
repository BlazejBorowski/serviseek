<?php

declare(strict_types=1);

namespace Modules\Services;

use Illuminate\Support\ServiceProvider;
use Modules\Services\Actions\AddRandomServices;
use Modules\Services\Actions\AddRandomServices\AddRandomServiceBasic;
use Modules\Services\Repositories\ReadServiceEloquentRepository;
use Modules\Services\Repositories\ReadServiceRepository;
use Modules\Services\ValueObjects\Service;
use Modules\Services\ValueObjects\ServiceCategory;
use Modules\Services\ValueObjects\ServiceEmail;
use Modules\Services\ValueObjects\ServiceImage;
use Modules\Services\ValueObjects\ServicePhone;
use Modules\Services\ValueObjects\ServiceTag;
use Modules\Services\ValueObjects\Validators\ServiceCategoryValidator;
use Modules\Services\ValueObjects\Validators\ServiceEmailValidator;
use Modules\Services\ValueObjects\Validators\ServiceImageValidator;
use Modules\Services\ValueObjects\Validators\ServicePhoneValidator;
use Modules\Services\ValueObjects\Validators\ServiceTagValidator;
use Modules\Services\ValueObjects\Validators\ServiceValidator;

class ServicesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AddRandomServices::class, AddRandomServiceBasic::class);

        $this->app->bind(ReadServiceRepository::class, ReadServiceEloquentRepository::class);

        $this->app->bind(Service::class, function ($app, $parameters) {
            $validator = $app->make(ServiceValidator::class);
            $validatedData = $validator->validate($parameters['data'] ?? []);

            return new Service($validatedData);
        });

        $this->app->bind(ServiceCategory::class, function ($app, $parameters) {
            $validator = $app->make(ServiceCategoryValidator::class);
            $validatedData = $validator->validate($parameters['data'] ?? []);

            return new ServiceCategory($validatedData);
        });

        $this->app->bind(ServiceEmail::class, function ($app, $parameters) {
            $validator = $app->make(ServiceEmailValidator::class);
            $validatedData = $validator->validate($parameters['data'] ?? []);

            return new ServiceEmail($validatedData);
        });

        $this->app->bind(ServicePhone::class, function ($app, $parameters) {
            $validator = $app->make(ServicePhoneValidator::class);
            $validatedData = $validator->validate($parameters['data'] ?? []);

            return new ServicePhone($validatedData);
        });

        $this->app->bind(ServiceTag::class, function ($app, $parameters) {
            $validator = $app->make(ServiceTagValidator::class);
            $validatedData = $validator->validate($parameters['data'] ?? []);

            return new ServiceTag($validatedData);
        });

        $this->app->bind(ServiceImage::class, function ($app, $parameters) {
            $validator = $app->make(ServiceImageValidator::class);
            $validatedData = $validator->validate($parameters['data'] ?? []);

            return new ServiceImage($validatedData);
        });
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}

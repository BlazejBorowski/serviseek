<?php

declare(strict_types=1);

namespace BlazejBorowski\LaravelValueObjects;

use BlazejBorowski\LaravelValueObjects\Validators\EmailValidator;
use Blazejborowski\LaravelValueObjects\Values\Email;
use Illuminate\Support\ServiceProvider;

class ValueObjectsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Email::class, function ($app, $parameters) {
            $validator = $app->make(EmailValidator::class);
            $validatedData = $validator->validate($parameters['data'] ?? []);

            return new Email($validatedData);
        });
    }

    public function boot(): void {}
}

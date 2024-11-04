<?php

declare(strict_types=1);

namespace BlazejBorowski\LaravelValueObjects\Validators;

class EmailValidator extends ValueObjectValidator
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
        ];
    }
}

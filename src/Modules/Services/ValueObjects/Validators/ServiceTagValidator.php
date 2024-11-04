<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects\Validators;

use BlazejBorowski\LaravelValueObjects\Validators\ValueObjectValidator;

class ServiceTagValidator extends ValueObjectValidator
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
